<?php

declare(strict_types=1);

namespace Baraja\EmailType;


final class Email implements \Stringable
{
	private string $email;


	public function __construct(string|self $haystack)
	{
		$email = is_string($haystack) ? $haystack : $haystack->getValue();
		$this->email = self::normalize($email);
	}


	public static function normalize(string $email): string
	{
		$email = mb_strtolower(trim($email), 'UTF-8');
		if ($email === '') {
			throw new \InvalidArgumentException('E-mail can not be empty.');
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			throw new \InvalidArgumentException('E-mail "' . $email . '" is not valid.');
		}

		return $email;
	}


	public function __toString(): string
	{
		return $this->getValue();
	}


	public function getValue(): string
	{
		return $this->email;
	}


	public function isEqualTo(string|self $email): bool
	{
		return $this->getValue() === (new self($email))->getValue();
	}
}
