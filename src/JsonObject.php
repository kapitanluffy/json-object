<?php

namespace Kapitanluffy\JsonObject;

class JsonObject implements \JsonSerializable
{
    /**
     * Data to be encoded
     *
     * @var mixed
     */
    protected $data;

    /**
     * JSON options
     *
     * @var int
     */
    protected $options = 0;

    /**
     * Flag for determining if errors are thrown
     *
     * @var bool
     */
    protected $throw = false;

    /**
     * JsonObject constructor
     *
     * @param mixed $data
     * @param int    $options
     * @param bool   $throw
     */
    public function __construct($data, $options = 0, $throw = false) {
        $this->data = $data;
        $this->options= $options;
        $this->throw = $throw;
    }

    /**
     * Return an instance with new options
     *
     * @param  int $options
     *
     * @return self
     */
    public function options($options)
    {
        return new self($this->data, $options, $this->throw);
    }

    /**
     * Return an instance that throws JSON errors
     *
     * @param  bool   $throw
     *
     * @return self
     */
    public function withErrors($throw = true)
    {
        return new self($this->data, $this->options, (bool) $throw);
    }

    /**
     * Shows if current instance throws errors
     *
     * @return bool
     */
    public function isErrorThrown()
    {
        return $this->throw;
    }

    /**
     * Encode current JsonObject
     *
     * @param  int    $depth
     *
     * @return string
     * @throws JsonError
     */
    public function encode($depth = 512)
    {
        $json = json_encode($this->data, $this->options, $depth);

        $error = self::getError();
        if ($error && $this->isErrorThrown()) {
            throw $error;
        }

        return $json;
    }

    /**
     * Decodes provided JsonObject
     *
     * @param  JsonObject $json
     * @param  int        $depth
     *
     * @return mixed
     * @throws JsonError
     */
    public static function decode(JsonObject $json, $depth = 512)
    {
        $data = json_decode($json->encode(), true, $depth);

        $error = self::getError();
        if ($error && $json->isErrorThrown()) {
            throw $error;
        }

        return $data;
    }

    /**
     * Returns the last JSON error
     *
     * @return JsonError|null
     */
    public static function getError()
    {
        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE) {
            $message = json_last_error_msg();
            return new JsonException($message, $error);
        }
    }

    /**
     * Returns data to be JSON-encoded
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Returns JSON-encoded data
     *
     * @return string
     */
    public function __toString()
    {
        return $this->encode();
    }
}
