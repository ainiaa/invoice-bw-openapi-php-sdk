<?php

namespace InvoiceOpenApi\VO;

class BaseVO implements Arrayable
{
    public function toArray()
    {
        $return = get_object_vars($this);
        foreach ($return as $key => $value)
        {
            if (is_array($value))
            {
                foreach ($value as $idx => $it)
                {
                    if (is_subclass_of($it, 'InvoiceOpenApi\VO\BaseVO'))
                    {
                        $return[$key][$idx] = $it->toArray();
                    }
                }
            }
            else if (is_subclass_of($value, 'InvoiceOpenApi\VO\BaseVO'))
            {
                $return[$key] = $value->toArray();
            }
        }

        return $return;
    }
}