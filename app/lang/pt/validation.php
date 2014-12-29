<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| O following language lines contain O default error messages used by
	| O validator class. Some of Ose rules have multiple versions such
	| as O size rules. Feel free to tweak each of Ose messages here.
	|
	*/

	"accepted"             => "O :attribute deve ser aceito.",
	"active_url"           => "O :attribute não é uma URL válida.",
	"after"                => "O :attribute deve ser uma data posterior a :date.",
	"alpha"                => "O :attribute deve conter somente letras.",
	"alpha_dash"           => "O :attribute deve conter somente letras, números e hífen.",
	"alpha_num"            => "O :attribute deve conter somente letras e números.",
	"array"                => "O :attribute deve ser um array.",
	"before"               => "O :attribute deve ser uma data anterior a :date.",
	"between"              => array(
		"numeric" => "O :attribute deve estar entre :min e :max.",
		"file"    => "O :attribute deve estar entre :min e :max kilobytes.",
		"string"  => "O :attribute deve estar entre :min e :max caracteres.",
		"array"   => "O :attribute deve conter entre :min e :max items.",
	),
	"boolean"              => "O :attribute deve ser verdadeiro ou falso.",
	"confirmed"            => "O :attribute confirmation não é válida.",
	"date"                 => "O :attribute não é uma data válida.",
	"date_format"          => "O :attribute não combina com o formato :format.",
	"different"            => "O :attribute e :other devem ser diferentes.",
	"digits"               => "O :attribute deve ser :digits digitos.",
	"digits_between"       => "O :attribute deve estar entre :min e :max digitos.",
	"email"                => "O :attribute deve ser um endereço de e-mail válido.",
	"exists"               => "O :attribute escolhido é inválido.",
	"image"                => "O :attribute deve ser uma imagem.",
	"in"                   => "O :attribute escolhido é inválido.",
	"integer"              => "O :attribute deve ser um inteiro",
	"ip"                   => "O :attribute deve ser um endereço de IP válido",
	"max"                  => array(
		"numeric" => "O :attribute deve ser maior que :max.",
		"file"    => "O :attribute deve ser maior que :max kilobytes.",
		"string"  => "O :attribute deve ser maior que :max caracteres.",
		"array"   => "O :attribute deve conter mais que :max items.",
	),
	"mimes"                => "O :attribute deve ser um arquivo do tipo: :values.",
	"min"                  => array(
		"numeric" => "O :attribute deve ser ao menos :min.",
		"file"    => "O :attribute deve ser ao menos :min kilobytes.",
		"string"  => "O :attribute deve ser ao menos :min caracteres.",
		"array"   => "O :attribute deve conter ao menos :min items.",
	),
	"not_in"               => "O :attribute escolhido é inválido.",
	"numeric"              => "O :attribute deve ser um número.",
	"regex"                => "O formato de :attribute é inválido.",
	"required"             => "O campo :attribute é obrigatório.",
	"required_if"          => "O campo :attribute é obrigatório quando :other é :value.",
	"required_with"        => "O campo :attribute é obrigatório quando :values é presente.",
	"required_with_all"    => "O campo :attribute é obrigatório quando :values é presente.",
	"required_without"     => "O campo :attribute é obrigatório quando :values não é presente.",
	"required_without_all" => "O campo :attribute é obrigatório quando nenhum dos :values está presente.",
	"same"                 => "O :attribute e :other devem combinar.",
	"size"                 => array(
		"numeric" => "O :attribute deve ser :size.",
		"file"    => "O :attribute deve ser :size kilobytes.",
		"string"  => "O :attribute deve ser :size characters.",
		"array"   => "O :attribute deve ser :size items.",
	),
	"unique"               => "O :attribute já existe.",
	"url"                  => "O formato do :attribute é invalido.",
	"timezone"             => "O :attribute deve ser uma zona válida.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using O
	| convention "attribute.rule" to name O lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| O following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
