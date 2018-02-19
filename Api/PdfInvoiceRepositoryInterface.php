<?php
/**
 * Copyright © Pavel Leonidov. All rights reserved.
 */

namespace PavelLeonidov\WebApiPdfInvoice\Api;

/**
 * Class PdfInvoiceRepositoryInterface
 *
 * @api
 */
interface PdfInvoiceRepositoryInterface
{
    /**
     * @param int $id
     * @return string
     */
    public function getInvoiceForExportInPdfFormat($id);
}
