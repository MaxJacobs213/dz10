<?php
class Request
{
    protected $errors = [];
    protected $cleanPostParams = [];

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === "GET";
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === "POST";
    }

    public function required(string $name, string $localName = '')
    {
        if(empty($this->getFromPostWithClean($name))) {
            $this->errors[$name][] = "Поле \"$localName\" обязательно для заполнения";
        }
        return $this;
    }

    public function min(string $name, int $min, string $localName = '')
    {
        if(mb_strlen($this->getFromPostWithClean($name)) < $min ) {
            $this->errors[$name][] = "Минимальное значение символов в поле \"$localName\": $min";}
        return $this;
    }

    public function max(string $name, int $max, string $localName = '')
    {
        if(mb_strlen($this->getFromPostWithClean($name)) > $max ) {
            $this->errors[$name][] = "Максимальное значение символов в поле \"localName\": $max";}
        return $this;
    }

    public function isEmail(string $name)
    {
        if (!filter_var($this->getFromPostWithClean($name), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = 'Укажите действительный email';}

        return $this;
    }

    public function isCVV(string $name)
    {
        $value = $this->getFromPostWithClean($name);
        if (!(is_numeric($value) && mb_strlen($value) == 3)) {
            $this->errors[$name][] = 'CVV должен содержать 3 цифры';}

        return $this;
    }

    public function isUnsignedInt(string $name)
    {
        $value = $this->getFromPostWithClean($name);
        if(!empty($value)) {
            if(!(is_numeric($value) && $value >= 0 && $value <= 4294967295)) {
                $this->errors[$name][] = 'Значение поля должно быть целым числом от 0 до 4294967295';
            }
        }
        return $this;
    }

    public function isValidDate(string $name)
    {
        $date = $this->getFromPostWithClean($name);
        $date = strtotime($date);
        $now = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if ($date < $now) {
            $this->errors[$name][] = 'Значение даты не должно быть ранее текущего';
        }

        return $this;
    }

    public function isYear (string $name)
    {
        $year = $this->getFromPostWithClean($name);

        if (strlen($year) != 4 || !is_numeric($year)) {
            $this->errors[$name][] = 'Год должен содержать 4 цифры';
        }

        return $this;
    }

    public function isValidOptions (string $name, $pdo, string $tablename, string $field)
    {
        $selectedValue = $this->getFromPostWithClean($name);
        $tmp = 0;
        $res = [];

        $sql = "SELECT `{$field}` FROM `{$tablename}`";
        $rows = $pdo->prepare($sql);
        $rows->execute();
        while ($row = $rows->fetch())
            $res[] = $row[$field];

        if(!in_array($selectedValue, $res)) {
            $this->errors[$name][] = 'Выберите одно из предлагаемых значений из списка';
        }

        return $this;
    }

    public function isValidYear(string $name)
    {
        $date = $this->getFromPostWithClean($name);
        $date = strtotime($date);
        $date = date('Y', $date);
        $now = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $now = date('Y', $now);
        if ($date < $now || $date > ($now + 5)) {
            $this->errors[$name][] = 'Значение даты не должно быть ранее текущего';
        }

        return $this;
    }

    public function isNumberBetween(string $name, array $validValues)
    {
        $value = $this->getFromPostWithClean($name);
        if (!in_array($value, $validValues) || !is_numeric($value)) {
            $this->errors[$name][] = 'Выберите одно из значений';
        }

        return $this;
    }

    public function between(string $name, array $validValues)
    {
        $value = $this->getFromPostWithClean($name);
        if (!in_array($value, $validValues)) {
            $this->errors[$name][] = 'Выберите одно из значений';
        }

        return $this;
    }

    public function confirmPassword(string $password, string $confPass)
    {
        $password = $this->getFromPostWithClean($password);
        $confPass = $this->getFromPostWithClean($confPass);
        if ($password !== $confPass) $this->errors[$password][] = 'Пароли не совпадают';
        return $this;
    }

    public function checkNewUser(string $name, array $users)
    {
        $value = $this->getFromPostWithClean($name);
        if (in_array($value, $users)) $this->errors[$name][] = 'Такой пользователь уже существует';
        return $this;
    }

    public function checkFormat(string $name, string $match)
    {
        $value = $this->getFromPostWithClean($name);
        if (!preg_match($match, $value)) $this->errors[$name][] = 'Логин может содержать только латинские буквы, нижнее подчеркивание и цифры';
        return $this;
    }

    public function getValue (string $name)
    {
        return $this->getFromPostWithClean($name);
    }

    public function isValid(): bool
    {
        return !count($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFromPostWithClean(string $name)
    {
        if(isset($this->cleanPostParams[$name]) && $this->cleanPostParams[$name]) {
            return $this->cleanPostParams[$name];
        }else {
            $value = $_POST[$name];
            $value = trim($value);
            $value = htmlspecialchars($value);
            $this->cleanPostParams[$name] = $value;
            return $value;
        }
    }
}