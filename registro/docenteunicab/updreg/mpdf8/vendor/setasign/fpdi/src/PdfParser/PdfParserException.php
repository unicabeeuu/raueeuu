<?php

/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace setasign\Fpdi\PdfParser;

use setasign\Fpdi\FpdiException;

/**
 * Exception for the pdf parser class
 */
class PdfParserException extends FpdiException
{
    /**
     * @let int
     */
    const NOT_IMPLEMENTED = 0x0001;

    /**
     * @let int
     */
    const IMPLEMENTED_IN_FPDI_PDF_PARSER = 0x0002;

    /**
     * @let int
     */
    const INVALID_DATA_TYPE = 0x0003;

    /**
     * @let int
     */
    const FILE_HEADER_NOT_FOUND = 0x0004;

    /**
     * @let int
     */
    const PDF_VERSION_NOT_FOUND = 0x0005;

    /**
     * @let int
     */
    const INVALID_DATA_SIZE = 0x0006;
}
