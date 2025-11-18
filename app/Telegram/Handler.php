<?php

namespace App\Telegram;

use App\Enums\SpendingCategory;
use App\Jobs\CreateExpenseJob;
use App\Models\User;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stringable;

class Handler extends WebhookHandler
{
    public function register()
    {
        $text = $this->message->text();
        $email = trim(str_replace('/register', '', $text));
        $chat = $this->chat;
        if (!$chat) {
            $chat->save();
        }
        if ($chat->storage()->get('user')) {
            $this->reply('Вы уже зарегистрированы');
        } else {
            $validator = Validator::make(['email' => $email], ['email' => 'email|exists:users,email']);
            if ($validator->fails()) {
                $this->reply('Неправильный email');
            } else {
                $this->reply('Теперь введите пароль');
                $chat->storage()->set('user_email', $email);
                $chat->storage()->set('authentication', 'password');
            }
        }
    }

    public function add()
    {
        $chat = $this->chat;
        if (!$chat) {
            $chat->save();
        }
        if ($chat->storage()->get('add_status')) {
            $this->reply('Вы уже вводите сумму');
        } else {
            $this->reply('Введите сумму');
            $chat->storage()->set('add_status', 'value_input');
        }
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $chat = $this->chat;
        if (!$chat) {
            $chat->save();
        } else {
            if ($chat->storage()->get('authentication') == 'password') {
                $password = $this->message->text();
                $user = User::where('email', $chat->storage()->get('user_email'))->first();
                if ($user && Hash::check($password, $user->password)) {
                    $this->reply('Вы успешно зарегистрировались');
                    $chat->storage()->forget('authentication');
                    $chat->storage()->set('user', $user->id);
                } else {
                    $this->reply('Неправильный пароль');
                    $chat->storage()->forget('authentication');
                }
            }
            switch ($chat->storage()->get('add_status')) {
                case 'value_input':
                    $sum = (int)$text->value();
                    if ($sum != 0) {
                        $chat->storage()->set('sum', $sum);
                        $buttons = array_map(fn($value) => ReplyButton::make($value), SpendingCategory::values());
                        Telegraph::message("Отлично, вы ввели сумму $sum, теперь добавьте категорию")
                            ->replyKeyboard(ReplyKeyboard::make()->buttons($buttons))
                            ->send();
                        $chat->storage()->forget('add_status');
                        $chat->storage()->set('add_status', 'category_input');
                    } else {
                        $this->reply('Введите число');
                    }
                    break;
                case 'category_input':
                    $input = $text->value();
                    $chat->storage()->set('category', $input);
                    Telegraph::message("Вы выбрали: {$input}, добавьте комментарий")->replyKeyboard(
                        ReplyKeyboard::make()->buttons([
                            ReplyButton::make('Пропустить')
                        ])
                    )->send();
                    $chat->storage()->forget('add_status');
                    $this->chat->storage()->set('add_status', 'comment_input');
                    break;
                case 'comment_input':
                    $input = $text->value();
                    $sum = $chat->storage()->get('sum');
                    $category = $chat->storage()->get('category');
                    if ($input === 'Пропустить') {
                        Telegraph::message("Ваша запись: вы потратили $sum на категорию $category")
                            ->removereplyKeyboard()->send();
                    } else {
                        Telegraph::message(
                            "Ваша запись: вы потратили $sum на категорию $category с комментарием $input"
                        )->removeReplyKeyboard()->send();
                    }
                    if ($chat->storage()->get('user')) {
                        Telegraph::message($chat->storage()->get('user'))->send();
                        CreateExpenseJob::dispatch(
                            userid: $chat->storage()->get('user'),
                            category: $category,
                            comment: $input,
                            sum: $sum
                        );
                    }
                    $chat->storage()->forget('add_status');
                    $chat->storage()->forget('sum');
                    $chat->storage()->forget('category');
                    break;
            }
        }
    }

    public function forget()
    {
        $chat = $this->chat;
        $chat->storage()->forget('add_status');
        $chat->storage()->forget('sum');
        $chat->storage()->forget('category');
        $chat->storage()->forget('user');
        $chat->storage()->forget('user_email');
        $chat->storage()->forget('authentication');
        $this->reply('abandoned');
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() === '/start') {
            $this->reply('Hello!');
        } else {
            $this->reply($text->value());
        }
    }
}