<?php

namespace InvoiceOpenApi\VO;

class BaseVO implements Arrayable
{
    public function toArray()
    {
        return get_object_vars($this);
    }
}