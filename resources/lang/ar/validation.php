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

    'accepted' => ' :attribute يجب قبول.',
    'active_url' => ' :attribute ليس عنوان صالحآ.',
    'after' => ' :attribute يجب أن يكون تاريخ بعد :date.',
    'after_or_equal' => ' :attribute يجب أن يكون تاريخ بعد أو يساوي :date.',
    'alpha' => ' :attribute قد تحتوي على أحرف فقط.',
    'alpha_dash' => ' :attribute قد يحتوي فقط على أحرف وأرقام وشرطات وشرطات سفلية.',
    'alpha_num' => ' :attribute قد تحتوي فقط على حروف وأرقام.',
    'array' => ' :attribute يجب أن يكون مجموعة.',
    'before' => ' :attribute يجب أن يكون تاريخ من قبل :date.',
    'before_or_equal' => ' :attribute يجب أن يكون تاريخ قبل أو يساوي :date.',
    'between' => [
        'numeric' => ' :attribute يجب ان يكون بين :min و :max.',
        'file' => ' :attribute يجب ان يكون بين :min و :max كيلو بايت.',
        'string' => ' :attribute يجب ان يكون بين :min و :max حروف.',
        'array' => ' :attribute يجب أن يكون بين :min و :max عناصر.',
    ],
    'boolean' => ' :attribute يجب أن يكون الحقل صواب أو خطأ.',
    'confirmed' => ' :attribute التأكيد غير متطابق.',
    'date' => ' :attribute ليس تاريخ صحيح.',
    'date_equals' => ' :attribute يجب أن يكون تاريخ يساوي :date.',
    'date_format' => ' :attribute لا يتطابق مع شكل :format.',
    'different' => ' :attribute و :other يجب أن تكون مختلفة.',
    'digits' => ' :attribute يجب أن تكون  :digits أرقام.',
    'digits_between' => ' :attribute يجب أن يكون بين :min و :max أرقام.',
    'dimensions' => ' :attribute له أبعاد صورة غير صالحة.',
    'distinct' => ' :attribute الحقل له قيمة مكررة.',
    'email' => ' :attribute يجب أن يكون عنوان بريد إلكتروني صالح.',
    'ends_with' => ' :attribute يجب أن ينتهي مع واحد من following: :values',
    'exists' => 'اللمحددة :attribute غير صالحة.',
    'file' => ' :attribute يجب أن يكون ملف.',
    'filled' => ' :attribute يجب أن يكون الحقل قيمة.',
    'gt' => [
        'numeric' => ' :attribute يجب أن يكون أكبر من :value.',
        'file' => ' :attribute يجب أن يكون أكبر من :value كيلو بايت.',
        'string' => ' :attribute يجب أن يكون أكبر من :value حروف.',
        'array' => ' :attribute يجب أن يكون أكبر من :value عناصر.',
    ],
    'gte' => [
        'numeric' => ' :attribute يجب أن يكون أكبر من أو يساوي :value.',
        'file' => ' :attribute يجب أن يكون أكبر من أو يساوي :value كيلو بايت.',
        'string' => ' :attribute يجب أن يكون أكبر من أو يساوي :value حروف.',
        'array' => ' :attribute يجب ان يملك :value العناصر أو أكثر.',
    ],
    'image' => ' :attribute يجب أن تكون صورة.',
    'in' => 'اللمحددة :attribute غير صالحة.',
    'in_array' => ' :attribute الحقل غير موجود في :other.',
    'integer' => ' :attribute يجب أن يكون عددًا صحيحًا.',
    'ip' => ' :attribute يجب أن يكون عنوان IP صالحًا.',
    'ipv4' => ' :attribute يجب أن يكون عنوان IPv4 صالحًا.',
    'ipv6' => ' :attribute يجب أن يكون عنوان IPv6 صالحًا....',
    'json' => ' :attribute يجب أن تكون سلسلة JSON صالحة.',
    'lt' => [
        'numeric' => ' :attribute يجب أن يكون أقل من :value.',
        'file' => ' :attribute يجب أن يكون أقل من :value كيلو بايت.',
        'string' => ' :attribute يجب أن يكون أقل من :value حروف.',
        'array' => ' :attribute يجب أن يكون أقل من :value عناصر.',
    ],
    'lte' => [
        'numeric' => ' :attribute يجب أن يكون أقل من أو يساوي :value.',
        'file' => ' :attribute يجب أن يكون أقل من أو يساوي :value كيلو بايت.',
        'string' => ' :attribute يجب أن يكون أقل من أو يساوي :value حروف.',
        'array' => ' :attribute يجب ألا يكون أكثر من :value عناصر.',
    ],
    'max' => [
        'numeric' => ' :attribute قد لا يكون أكبر من :max.',
        'file' => ' :attribute قد لا يكون أكبر من :max كيلو بايت.',
        'string' => ' :attribute قد لا يكون أكبر من :max حروف.',
        'array' => ' :attribute قد لا يكون أكثر من :max عناصر.',
    ],
    'mimes' => ' :attribute يجب أن يكون ملف type: :values.',
    'mimetypes' => ' :attribute يجب أن يكون ملف type: :values.',
    'min' => [
        'numeric' => ' :attribute لا بد أن يكون على الأقل :min.',
        'file' => ' :attribute لا بد أن يكون على الأقل :min كيلو بايت.',
        'string' => ' :attribute لا بد أن يكون على الأقل :min حروف.',
        'array' => ' :attribute لا بد أن يكون على الأقل :min عناصر.',
    ],
    'not_in' => 'اللمحددة :attribute غير صالحة.',
    'not_regex' => ' :attribute التنسيق غير صالح.',
    'numeric' => ' :attribute يجب أن يكون رقما.',
    'present' => ' :attribute يجب أن يكون حقل الحالي.',
    'regex' => ' :attribute التنسيق غير صالح.',
    'required' => ' :attribute  مطلوب.',
    'required_if' => ' :attribute حقل مطلوب عندما :other يكون :value.',
    'required_unless' => ' :attribute الحقل مطلوب ما لم :other يكون فى :values.',
    'required_with' => ' :attribute حقل مطلوب عندما :values يكون present.',
    'required_with_all' => ' :attribute حقل مطلوب عندما :values تكون موجودة.',
    'required_without' => ' :attribute حقل مطلوب عندما :values غير موجود.',
    'required_without_all' => ' :attribute حقل مطلوب عند :values وجود أي من.',
    'same' => ' :attribute و :other يجب أن تطابق.',
    'size' => [
        'numeric' => ' :attribute يجب أن تكون :size.',
        'file' => ' :attribute يجب أن تكون :size كيلو بايت.',
        'string' => ' :attributeيجب أن تكون :size حروف.',
        'array' => ' :attribute يجب أن يحتوي على :size عناصر.',
    ],
    'starts_with' => ' :attribute يجب أن تبدأ مع واحد من following: :values',
    'string' => ' :attribute يجب أن يكون سلسلة.',
    'timezone' => ' :attribute يجب أن تكون منطقة صالحة.',
    'unique' => ' :attribute موجود مسبقآ.',
    'uploaded' => ' :attribute فشل في التحميل.',
    'url' => ' :attribute التنسيق غير صالح.',
    'uuid' => ' :attribute يجب أن يكون UUID صالح.',

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

    'attributes' => [
        'name' => 'الاسم',
        'phone' => 'الرقم التليفون',
        'email' => 'البريد الالكترونى',
        'password' => 'الكلمه السر',
        'image' => 'الصوره',
        'gender' => 'الجنس',
        'advertisement_name' => 'اسم الاعلان ',
        'advertisement_image' => 'صوره الاعلان',
        'advertisement_description_content' => 'وصف المحتوى للاعلان',
        'coupon_name' => 'اسم الكوبون',
        'coupon_discount' => 'خصم الكوبون',
        'interest_name' => 'اسم الاهتمام',
        'interest_name.*' => 'اسم الاهتمام',
        'status_name' => 'الحاله',
    ],

];
