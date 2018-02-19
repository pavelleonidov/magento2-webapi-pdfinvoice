<?php

namespace PavelLeonidov\WebApiPdfInvoice\Model\Invoice;

/*******************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Pavel Leonidov <info@pavel-leonidov.de>
 *
 *  All rights reserved
 *
 *  This script is part of the Magento 2 project. The Magento 2 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ******************************************************************/

use Magento\Framework\Exception\NoSuchEntityException;

use Magento\Sales\Model\Order\InvoiceRepository;

use PavelLeonidov\WebApiPdfInvoice\Api\PdfInvoiceRepositoryInterface;


use Eadesigndev\Pdfgenerator\Helper\Pdf;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Sales\Model\ResourceModel\Metadata;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Eadesigndev\Pdfgenerator\Model\PdfgeneratorRepository;



class PdfInvoiceRepository implements PdfInvoiceRepositoryInterface {

	/**
	 * PdfInvoiceRepository constructor
	 * @param Metadata $invoiceMetadata
	 * @param Pdf $helper
	 * @param DateTime $dateTime
	 * @param FileFactory $fileFactory
	 * @param PdfgeneratorRepository $pdfGeneratorRepository
	// * @param \PavelLeonidov\WebApiRestPdf\Model\Order\PdfInvoiceRepositoryResponseInterfaceFactory $dataFactory
	 * @param InvoiceRepository $invoiceRepository
	 */
	public function __construct(
		Pdf $helper,
		PdfgeneratorRepository $pdfGeneratorRepository,
		InvoiceRepository $invoiceRepository
	) {
		$this->pdfGeneratorRepository = $pdfGeneratorRepository;
		$this->helper = $helper;
		$this->invoiceRepository = $invoiceRepository;

	}

	/**
	 *
	 * This prototype method deliberately just returnes the ID in order to pass it to the renderer interface
	 *
	 *
	 * @param int $id
	 * @return string
	 * @throws NoSuchEntityException
	 * @throws \Magento\Framework\Exception\InputException
	 */
	public function getInvoiceForExportInPdfFormat(
		$id
	) {

		if (!$id) {
			throw new \Magento\Framework\Exception\InputException(__('ID required'));
		}

		$templateId = 1;


		$templateModel = $this->pdfGeneratorRepository
			->getById($templateId);


		$invoiceObject = $this->invoiceRepository
			->get($id);

			$helper = $this->helper;

			$helper->setInvoice($invoiceObject);
			$helper->setTemplate($templateModel);
			$pdfFileData = $helper->template2Pdf();

		try {
			return base64_encode($pdfFileData['filestream']);

		} catch (\Exception $e) {
			echo $e->getMessage();

		}
		return null;
	}

}
?>