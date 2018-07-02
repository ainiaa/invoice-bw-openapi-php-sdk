<?php

namespace InvoiceOpenApi\VO;

use CoreOpenApi\VO\BaseVO;

class CompanySearchRequestVO extends BaseVO
{
    protected $companyName;//企业名称
    protected $taxId;//企业税号
    protected $accuracy;//是否精确查找； true表示精确查找;false表示模糊查找；默认false
    private $sortNo;//排序方式；0表示降序，1表示升序；默认0
    protected $sort;//设置好的(需要处理，调用接口用的)。

    protected $rule = [
        ['companyName', 'require', 'companyName required'],
    ];

    /**
     * @return mixed
     */
    public function getSortNo()
    {
        return $this->sortNo;
    }

    /**
     * @param mixed $sortNo
     */
    public function setSortNo($sortNo)
    {
        $this->sortNo = $sortNo;
        $this->setSort($sortNo);
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sortNo
     */
    protected function setSort($sortNo)
    {
        $this->sort = sprintf('{“frequency”: %d}', $sortNo);
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     *
     * @return CompanySearchRequestVO
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * @param mixed $taxId
     *
     * @return CompanySearchRequestVO
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * @param mixed $accuracy
     *
     * @return CompanySearchRequestVO
     */
    public function setAccuracy($accuracy)
    {
        if (is_bool($accuracy))
        {
            $accuracy = strval($accuracy);
        }
        $this->accuracy = $accuracy;

        return $this;
    }
}