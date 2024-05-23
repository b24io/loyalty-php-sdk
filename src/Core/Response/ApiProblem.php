<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response;

class ApiProblem
{
    /**
     * @readonly
     */
    public string $title;
    /**
     * @readonly
     */
    public string $type;
    /**
     * @readonly
     */
    public int $status;
    /**
     * @readonly
     */
    public string $detail;
    /**
     * @readonly
     */
    public string $instance;

    public function __construct(
        string $title,
        string $type,
        int    $status,
        string $detail,
        string $instance)
    {
        $this->title = $title;
        $this->type = $type;
        $this->status = $status;
        $this->detail = $detail;
        $this->instance = $instance;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['type'],
            $data['status'],
            $data['detail'],
            $data['instance'],
        );
    }
}