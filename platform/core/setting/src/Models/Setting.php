<?php

namespace Botble\Setting\Models;

use Botble\Base\Models\BaseModel;

class Setting extends BaseModel
{
    const MAILS = 'mails';

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];
}
