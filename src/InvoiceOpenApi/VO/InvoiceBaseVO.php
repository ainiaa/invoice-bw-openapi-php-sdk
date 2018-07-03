<?php
namespace InvoiceOpenApi\VO;

use CoreOpenApi\VO\BaseVO;

class InvoiceBaseVO extends BaseVO
{
    protected $taxDiskNo;//税控盘编号，设备类型为1时必填
    protected $taxDiskKey;//税控盘口令，设备类型为1时必填
    protected $taxDiskPassword;//税务数字证书密码，设备类型为1时必填

    /**
     * @return mixed
     */
    public function getTaxDiskNo()
    {
        return $this->taxDiskNo;
    }

    /**
     * @param mixed $taxDiskNo
     *
     * @return InvoiceBaseVO
     */
    public function setTaxDiskNo($taxDiskNo)
    {
        $this->taxDiskNo = $taxDiskNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxDiskKey()
    {
        return $this->taxDiskKey;
    }

    /**
     * @param mixed $taxDiskKey
     *
     * @return InvoiceBaseVO
     */
    public function setTaxDiskKey($taxDiskKey)
    {
        $this->taxDiskKey = $taxDiskKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxDiskPassword()
    {
        return $this->taxDiskPassword;
    }

    /**
     * @param mixed $taxDiskPassword
     *
     * @return InvoiceBaseVO
     */
    public function setTaxDiskPassword($taxDiskPassword)
    {
        $this->taxDiskPassword = $taxDiskPassword;

        return $this;
    }

}