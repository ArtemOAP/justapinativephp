<?php

namespace App\Api;


class Request implements RequestInterface
{

    const POST = "POST";
    const GET = "GET";
    const PUT = "PUT";
    const DELETE = "DELETE";

    protected static $count = 0;

    protected $id;
    /** @var array */
    protected $nodesPath;
    protected $param;
    protected $method;
    protected $body;
    protected $paramInt;
    protected $action;
    protected $is_public;

    public function __construct($patch, $method, $action, bool $is_public = false, $param = null, $body = null)
    {
        self::$count++;
        $this->is_public = $is_public;
        $this->action    = $action;
        $this->method    = $method;
        $this->nodesPath = self::patchToArray($patch);


        $this->param     = $param;
        $this->body      = $body;
        $this->id        = self::$count;
    }
    public static function patchToArray(string $patch) : array {
        return array_filter(explode('/', $patch), function ($el) {
            return !empty($el);
        });
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * @param bool $is_public
     */
    public function setIsPublic(bool $is_public): void
    {
        $this->is_public = $is_public;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getNodesPath(): array
    {
        return $this->nodesPath;
    }

    /**
     * @param array $nodesPath
     */
    public function setNodesPath(array $nodesPath): void
    {
        $this->nodesPath = $nodesPath;
    }

    /**
     * @return null
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param null $param
     */
    public function setParam($param): void
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param null $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getParamInt()
    {
        return $this->paramInt;
    }

    /**
     * @param mixed $paramInt
     */
    public function setParamInt($paramInt): void
    {
        $this->paramInt = $paramInt;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }


}