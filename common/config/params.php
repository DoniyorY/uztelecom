<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 6,

    'company_count' => 2,
    'company_id' => [
        1 => 'SIMMA HOTEL SPA&WATERPARK',
        2 => 'OOO GLOBAL TRADING',
    ],
    'company_doc_alias' => [
        1 => 'SS-1/',
        2 => 'GT-2/',
    ],
    'company_id_logo_link' => [
        1 => '',
        2 => '',
    ],
    'company_id_blank_info' => [
        1 => 'Ўзбекистон Республикаси. Тошкент шаҳри,, Янгихаёт тумани.,  «Пастдархон» МФЙ,  Навруз-22 кўчаси, Тел: +99895 209-29-99. х/р 20208000700930057001  АИКБ «Ipakyuli» Яккасарой.фил-л. МФО 01028. ИНН 305 796 153. ОКЭД 55100. ',
        2 => '',
    ],
    'company_id_director' => [
        1 => 'Ш.Х.Давлатов',
        2 => '',
    ],
    'company_alias' => [
        1 => 'ooo_sim_salabim',
        2 => 'ooo_trading',
    ],
    'termnal_type' => [
        1 => 'ВХОД <i class="ri-speed-fill"></i>',
        2 => '<i class="ri-rewind-fill"></i> ВЫХОД',
    ],
    'task_status' => [
        0 => 'Новый',
        1 => 'В процессе',
        2 => 'Выполнен',
        3 => 'Отказано',
        4 => 'Просрочено',
    ],
    'task_status_class' => [
        0 => 'badge bg-info',
        1 => 'badge bg-primary',
        2 => 'badge bg-success',
        3 => 'badge bg-danger',
        4 => 'badge bg-warning',
    ],
    'task_position' => [
        0 => 'НОВЫЕ',
        1 => 'В ПРОЦЕССЕ',
        2 => 'ВЫПОЛНЕН',
        3 => 'ОТМЕНЕН',
    ],
    'task_position_class' => [
        0 => 'badge bg-warning',
        1 => 'badge bg-primary',
        2 => 'badge bg-success',
        3 => 'badge bg-danger',
    ],
    'task_level_id' => [
        1 => 'Обычная задача',
        2 => 'Среднее важная',
        3 => 'Важная задача',
        4 => 'Первостепенная задача',
    ],
    'task_level_id_style' => [
        1 => '<span class="badge badge-label bg-primary"><i class="mdi mdi-circle-medium"></i>Обычная задача</span>',
        2 => '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>Среднее важная</span>',
        3 => '<span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>Важная задача</span>',
        4 => '<span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i>Первостепенная задача</span>',
    ],
    'user_status' => [
        10 => 'Активный',
        9 => 'Отключённый',
        0 => 'Удаленный',
    ],
    'user_status_style' => [
        10 => '',
        9 => 'table-warning',
        0 => 'table-danger',
    ],
    'notification_model_type' => [
        0 => 'Задачи / Task',
        1 => 'Оповещения / News'
    ],
    'attendance_records_status' => [
        0 => 'Вовремя',
        1 => 'Опоздал',
        2 => 'Отсутствовал',
        3 => 'Отпуск',
        4 => 'Больничный',
        5 => 'Командировка',
        6 => 'Выходной',
    ],
    'attendance_records_source' => [
        0 => 'Ручной',
        1 => 'Автоматически',
        2 => 'Мобильное',
        3 => 'Импортирован',
    ],
    'gridViewPager' => [
        'prevPageLabel' => '<span class="page-item">Пред</span>',
        'nextPageLabel' => '<span class="page-item">След</span>',
        'disabledPageCssClass' => 'page-link',
        'activePageCssClass' => 'page-item active',
        'maxButtonCount' => 5,
        'linkOptions' => ['class' => 'page-link'],
        'options' => [
            'tag' => 'ul',
            'class' => 'pagination',
            'style' => 'margin-top: 5px'
        ],
    ],
    'order_status' => [
        0 => 'Не проверено',
        1 => 'Подтверждено',
        2 => 'Отклонено',
        3 => 'Частично подтверждено'
    ],
    'order_status_class' => [
        0 => 'badge bg-warning-subtle text-warning badge-border',
        1 => 'badge bg-success-subtle text-success',
        2 => 'badge bg-info-subtle text-info',
    ]

];
