<?php

return [
    'account' => 'アカウント',
    'personal_details' => '個人情報',
    'security' => 'セキュリティ',
    'credits' => 'クレジット',

    'change_password' => 'パスワードを変更',

    'two_factor_authentication' => '二段階認証',
    'two_factor_authentication_description' => '二段階認証を有効にすることで、あなたのアカウントをより安全に保つことができます。',
    'two_factor_authentication_enabled' => '二段階認証があなたのアカウントで有効になりました',
    'two_factor_authentication_enable' => '二段階認証を有効にする',
    'two_factor_authentication_disable' => '二段階認証を無効にする',
    'two_factor_authentication_disable_description' => '二段階認証を無効にしますか？この操作を行うと、アカウントの安全性をさらに高める仕組みが失われてしまいます。',
    'two_factor_authentication_enable_description' => '二段階認証を有効にするには、Google Authenticatorなどの認証アプリで、以下のQRコードをスキャンしてください。',
    'two_factor_authentication_qr_code' => 'このQRコードを認証アプリでスキャンしてください:',
    'two_factor_authentication_secret' => 'または手動でこのコードを入力してください:',

    'sessions' => 'セッション',
    'sessions_description' => '他のブラウザやデバイスでログイン中のセッションを確認し、必要に応じてログアウトすることができます。',
    'logout_sessions' => 'このセッションからログアウト',
    'current_device' => 'このデバイス',

    'input' => [
        'current_password' => '現在のパスワード',
        'current_password_placeholder' => 'Your current password',
        'new_password' => '新しいパスワード',
        'new_password_placeholder' => 'Your new password',
        'confirm_password' => 'パスワードを確認',
        'confirm_password_placeholder' => 'Confirm your new password',

        'two_factor_code' => '認証アプリに表示されているコードを入力してください',
        'two_factor_code_placeholder' => '二段階認証コード',

        'currency' => '通貨',
        'amount' => '金額',
        'payment_gateway' => 'Payment gateway',
    ],

    'notifications' => [
        'password_changed' => 'パスワードが変更されました。',
        'password_incorrect' => 'パスワードが間違っています。',
        'two_factor_enabled' => '二段階認証が有効になりました',
        'two_factor_disabled' => '二段階認証が無効になりました',
        'two_factor_code_incorrect' => 'コードが間違っています',
        'session_logged_out' => 'このセッションはログアウトされました',
    ],

    'no_credit' => 'あなたはクレジットを持っていません',
    'add_credit' => 'クレジットを追加',
    'credit_deposit' => 'クレジット (:currency)',

    'payment_methods' => 'お支払い方法',
    'recent_transactions' => '最近の取引',
    'saved_payment_methods' => '保存した支払い方法',
    'setup_payment_method' => '新しい支払い方法を追加',
    'no_saved_payment_methods' => '現在、保存した支払い方法はありません。',
    'saved_payment_methods_description' => 'Manage your saved payment methods for faster checkout and automatic payments.',
    'no_saved_payment_methods_description' => 'You can add a payment method to make future payments faster and easier, and enable automatic payments for your services.',
    'add_payment_method' => 'Add payment method',
    'payment_method_statuses' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'expired' => 'Expired',
        'pending' => 'Pending',
    ],
    'payment_method_added' => 'Payment method has been added.',
    'payment_method_add_failed' => 'Failed to add payment method. Please try again.',
    'services_linked' => ':count service(s) linked',
    'remove' => 'Remove',
    'remove_payment_method' => 'Remove Payment Method',
    'remove_payment_method_confirm' => 'Are you sure you want to remove :name? This action cannot be undone.',
    'expires' => 'Expires :date',
    'cancel' => 'Cancel',
    'confirm' => 'Yes, Remove',
    'email_notifications' => 'Email Notifications',
    'in_app_notifications' => 'In-App Notifications',
    'notifications_description' => 'Manage your notification preferences. You can choose to receive notifications via email, in-app (push), or both.',
    'notification' => 'Notification',

    'push_notifications' => 'Push Notifications',
    'push_notifications_description' => 'Enable push notifications to receive real-time updates directly in your browser, even when you are not on the site.',
    'enable_push_notifications' => 'Enable Push Notifications',
    'push_status' => [
        'not_supported' => 'Push notifications are not supported by your browser.',
        'denied' => 'Push notifications are blocked. Please enable them in your browser settings.',
        'subscribed' => 'Push notifications are enabled.',
    ],
];
