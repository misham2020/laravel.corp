<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ' :attribute должен быть принят.',
    'active_url' => ' :attribute не является допустимым URL-адресом.',
    'after' => ' :attribute должен быть датой после :date.',
    'after_or_equal' => ' :attribute должен быть датой после или равен :date.',
    'alpha' => ' :attribute может содержать только буквы.',
    'alpha_dash' => ' :attribute может содержать только буквы, цифры, тире и подчеркивания.',
    'alpha_num' => ' :attribute может содержать только буквы и цифры.',
    'array' => ' :attribute должен быть массивом.',
    'before' => ' :attribute олжен быть датой перед датой :date.',
    'before_or_equal' => ' :attribute должен быть датой раньше или равна :date.',
    'between' => [
        'numeric' => ' :attribute должен находиться между :min and :max.',
        'file' => ' :attribute должен находиться между :min и :max килобайтами.',
        'string' => ' :attribute должен находиться между :min и :max персонажами.',
        'array' => ' :attribute должен быть между :min and :max элементом.',
    ],
    'boolean' => ' :attribute должно быть правдой или ложью.',
    'confirmed' => ' :attribute не подтверждены.',
    'date' => ' :attribute это не действительная дата.',
    'date_equals' => ' :attribute должна быть дата, равная :date.',
    'date_format' => ' :attribute не соответствует формату :format.',
    'different' => ' :attribute и :other должна быть другой.',
    'digits' => ' :attribute должен быть :digits цифрой.',
    'digits_between' => ' :attribute должно быть между :min и :max цифрами.',
    'dimensions' => ' :attribute имеет недопустимые размеры изображения.',
    'distinct' => ' :attribute поле содержит повторяющиеся значения.',
    'email' => ' :attribute должен быть действительный адрес электронной почты.',
    'ends_with' => ' :attribute должен заканчиваться одним из следующих значений: :values.',
    'exists' => ' Некоторые :attribute недопустимый.',
    'file' => ' :attribute должно быть файлом.',
    'filled' => ' :attribute поле должно иметь значение.',
    'gt' => [
        'numeric' => ' :attribute должно быть больше, чем :value.',
        'file' => ' :attribute должно быть больше, чем :value kilobytes.',
        'string' => ' :attribute должно быть больше, чем :value characters.',
        'array' => ' :attribute должно быть больше, чем :value items.',
    ],
    'gte' => [
        'numeric' => ' :attribute должно быть больше или равно :value.',
        'file' => ' :attribute должно быть больше или равно :value kilobytes.',
        'string' => ' :attribute должно быть больше или равно :value characters.',
        'array' => ' :attribute должен иметь :value значения или более.',
    ],
    'image' => ' :attribute must be an image.',
    'in' => ' selected :attribute is invalid.',
    'in_array' => ' :attribute field does not exist in :other.',
    'integer' => ' :attribute must be an integer.',
    'ip' => ' :attribute must be a valid IP address.',
    'ipv4' => ' :attribute must be a valid IPv4 address.',
    'ipv6' => ' :attribute must be a valid IPv6 address.',
    'json' => ' :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => ' :attribute must be less than :value.',
        'file' => ' :attribute must be less than :value kilobytes.',
        'string' => ' :attribute must be less than :value characters.',
        'array' => ' :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => ' :attribute must be less than or equal :value.',
        'file' => ' :attribute must be less than or equal :value kilobytes.',
        'string' => ' :attribute must be less than or equal :value characters.',
        'array' => ' :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ' :attribute may not be greater than :max.',
        'file' => ' :attribute may not be greater than :max kilobytes.',
        'string' => ' :attribute may not be greater than :max characters.',
        'array' => ' :attribute may not have more than :max items.',
    ],
    'mimes' => ' :attribute must be a file of type: :values.',
    'mimetypes' => ' :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ' :attribute must be at least :min.',
        'file' => ' :attribute must be at least :min kilobytes.',
        'string' => ' :attribute must be at least :min characters.',
        'array' => ' :attribute must have at least :min items.',
    ],
    'not_in' => ' selected :attribute is invalid.',
    'not_regex' => ' :attribute format is invalid.',
    'numeric' => ' :attribute must be a number.',
    'password' => ' password is incorrect.',
    'present' => ' :attribute field must be present.',
    'regex' => ' :attribute format is invalid.',
    'required' => ':attribute поле обязательно.',
    'required_if' => ' :attribute field is required when :other is :value.',
    'required_unless' => ' :attribute field is required unless :other is in :values.',
    'required_with' => ' :attribute field is required when :values is present.',
    'required_with_all' => ' :attribute field is required when :values are present.',
    'required_without' => ' :attribute field is required when :values is not present.',
    'required_without_all' => ' :attribute field is required when none of :values are present.',
    'same' => ' :attribute and :other must match.',
    'size' => [
        'numeric' => ' :attribute must be :size.',
        'file' => ' :attribute must be :size kilobytes.',
        'string' => ' :attribute must be :size characters.',
        'array' => ' :attribute must contain :size items.',
    ],
    'starts_with' => ' :attribute must start with one of the following: :values.',
    'string' => ' :attribute must be a string.',
    'timezone' => ' :attribute must be a valid zone.',
    'unique' => ' :attribute has already been taken.',
    'uploaded' => ' :attribute failed to upload.',
    'url' => ' :attribute format is invalid.',
    'uuid' => ' :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
