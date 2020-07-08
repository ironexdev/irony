<?php

namespace App\Api\Service;

use App\Translator\Translator;
use Error;
use JsonSchema\Validator;

class ApiService
{
    /**
     * @param object $data
     * @param string $schema
     * @return string
     */
    public function validateApiDefinition(object $data, string $schema): string
    {
        $validator = new Validator;
        $validator->validate($data, (object) ['$ref' => $schema]);

        if ($validator->isValid()) {
            return "The supplied JSON validates against the schema.";
        }

        return json_encode($validator->getErrors(), JSON_PRETTY_PRINT);
    }

    /**
     * @param array $array
     * @param array $definition
     * @return array
     * @throws \App\Api\Exception\Http\BadRequestException
     */
    public function validateArray(array $array, array $definition): array
    {
        $result = [];

        if(!$array && $definition["required"])
        {
            $result[0]["required"] = true;
            return $result;
        }

        if(!$array && !$definition["required"])
        {
            return $result;
        }

        foreach($array as $index => $value)
        {
            $definedValueType = $definition["type"];
            $valueType = $this->getType($value);

            if ($valueType !== $definedValueType)
            {
                $result[$index]["type"] = $definedValueType;
                continue;
            }

            if (!in_array($valueType, ["array", "object"])) // scalar
            {
                if(isset($definition["format"]["regex"]) && !$this->validateParameterFormat($value, $definition["format"]["regex"]))
                {
                    $message = isset($definition["format"]["message"]) ? __($definition["format"]["message"]) : Translator::__("__x__Invalid value.__/x__");
                    $result[$index]["format"] = $message;
                }
            }
            else if($valueType === "array") // array
            {
                /** @var array $value */
                $arrayValidationResult = $this->validateArray($value, $definition["content"]);

                if($arrayValidationResult)
                {
                    $result[$index] = $arrayValidationResult;
                }
            }
            else // object
            {
                /** @var object $value */
                $objectValidationResult = $this->validateObject($value, $definition["content"]);

                if($objectValidationResult)
                {
                    $result[$index]["parameters"] = $objectValidationResult;
                }
            }
        }

        return $result;
    }

    /**
     * @param object $object
     * @param array $definition
     * @return array
     * @throws \App\Api\Exception\Http\BadRequestException
     */
    public function validateObject(object $object, array $definition): array
    {
        $result = [];

        foreach ($definition as $parameter => $parameterDefinition)
        {
            $parameterExists = property_exists($object, $parameter);
            if ($parameterDefinition["required"] && !$parameterExists)
            {
                $result[$parameter]["required"] = true;
                continue;
            }

            if (!$parameterDefinition["required"] && !$parameterExists)
            {
                continue;
            }

            $definedValueType = $parameterDefinition["type"];
            $value = $object->{$parameter};
            $valueType = $this->getType($value);

            if ($valueType !== $parameterDefinition["type"])
            {
                $result[$parameter]["type"] = $definedValueType;
                continue;
            }

            if (!in_array($valueType, ["array", "object"])) // scalar
            {
                if(isset($parameterDefinition["format"]["regex"]) && !$this->validateParameterFormat($value, $parameterDefinition["format"]["regex"]))
                {
                    $message = isset($parameterDefinition["format"]["message"]) ? Translator::__($parameterDefinition["format"]["message"]) : Translator::__("__x__Invalid value.__/x__");
                    $result[$parameter]["format"] = $message;
                }
            }
            else if($valueType === "array") // array
            {
                /** @var array $value */
                $arrayValidationResult = $this->validateArray($value, $parameterDefinition["content"]);

                if($arrayValidationResult)
                {
                    $result[$parameter] = $arrayValidationResult;
                }
            }
            else // object
            {
                /** @var object $value */
                $objectValidationResult = $this->validateObject($value, $parameterDefinition["content"]);

                if($objectValidationResult)
                {
                    $result[$parameter]["parameters"] = $objectValidationResult;
                }
            }
        }

        return $result;
    }

    /**
     * @param $value
     * @return string
     */
    private function getType($value): string
    {
        return gettype($value);
    }

    /**
     * @param $value
     * @param $regex
     * @return bool
     */
    private function validateParameterFormat($value, $regex): bool
    {
        $matched = preg_match($regex, $value);

        if ($matched === false)
        {
            throw new Error("Function preg_match returned false.");
        }

        if ($matched === 0)
        {
            return false;
        }

        return true;
    }
}