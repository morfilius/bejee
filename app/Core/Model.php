<?php


namespace app\Core;


class Model
{

    protected $data;

    protected $validationList;
    /**
     * @var DB
     */
    protected $db;

    public function __construct()
    {
        $this->db  = DB::getInstance()->getConnect();
    }


    public static function pdoSet($allowed, $source)
    {
        $set = '';

        foreach ($allowed as $field) {
            if (isset($source[$field])) {
                $set.= "`".str_replace("`","``",$field) . "`" . "=:$field, ";
            }
        }
        return substr($set, 0, -2);
    }


    public function validate(array &$errors = array())
    {
        if(empty($this->data) || empty($this->validationList)) return false;

        foreach($this->data as $key => $item) {
            if(!isset($this->validationList[$key]['rule'])) continue;

            $test = $this->validationHandler($this->validationList[$key]['rule'], $key, $this->data);

            if(!$this->validationHandler($this->validationList[$key]['rule'], $key, $this->data)) {
                $errors[$key] = ($this->validationList[$key]['error_msg']) ? $this->validationList[$key]['error_msg'] : 'Ошибка валидации';
            }
        }

        if(!empty($errors)) {
            $errors = array(
                'status' => 'error',
                'fields' => $errors
            );
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function load(array $data)
    {
        $this->data = array();

        if(empty($this->validationList)) return false;

        foreach($data as $key => $item) {
            if(!isset($this->validationList[$key]) || empty($this->validationList[$key])) continue;
                $this->data[$key] = $this->clearData($this->validationList[$key]['sanitize'], $item);
        }

        return true;
    }

    /**
     * @param array $validationList
     */
    public function setValidationList(array $validationList)
    {
        $this->validationList = $validationList;
    }


    protected function validationHandler($fieldRule, $fieldName, $source)
    {
        foreach ($fieldRule as $rule){
            switch($rule) {
                case ('required'):
                    if (isset($source[$fieldName]) && !empty($source[$fieldName])) continue;
                    return false;
                case ('email'):
                    if(filter_var($source[$fieldName], FILTER_VALIDATE_EMAIL)) continue;
                    return false;
                default:
                    return false;
            }
        }

       return true;
    }

    public static function clearData($fieldRule, $fieldValue)
    {
        switch($fieldRule) {
            case ('int'):
                return (int)$fieldValue;
            case ('email'):
                return filter_var($fieldValue, FILTER_SANITIZE_EMAIL);
            case ('sort'):
                switch($fieldValue) {
                    case ('description'):
                        return 'description';
                    case ('email'):
                        return 'email';
                    default:
                        return 'name';
                }
            case ('direction'):
                switch($fieldValue) {
                    case ('DESC'):
                        return 'DESC';
                    default:
                        return 'ASC';
                }
            default:
                return filter_var($fieldValue, FILTER_SANITIZE_STRING);
        }
    }
}