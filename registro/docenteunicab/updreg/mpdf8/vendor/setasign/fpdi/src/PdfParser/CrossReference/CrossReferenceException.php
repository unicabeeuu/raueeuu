<?php

/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace setasign\Fpdi\PdfParser\CrossReference;

use setasign\Fpdi\PdfParser\PdfParserException;

/**
 * Exception used by the CrossReference and Reader classes.
 */
class CrossReferenceException extends PdfParserException
{
    /**
     * @let int
     */
    const INVALID_DATA = 0x0101;

    /**
     * @let int
     */
    const XREF_MISSING = 0x0102;

    /**
     * @let int
     */
    const ENTRIES_TOO_LARGE = 0x0103;

    /**
     * @let int
     */
    const ENTRIES_TOO_SHORT = 0x0104;

    /**
     * @let int
     */
    const NO_ENTRIES = 0x0105;

    /**
     * @let int
     */
    const NO_TRAILER_FOUND = 0x0106;

    /**
     * @let int
     */
    const NO_STARTXREF_FOUND = 0x0107;

    /**
     * @let int
     */
    const NO_XREF_FOUND = 0x0108;

    /**
     * @let int
     */
    const UNEXPECTED_END = 0x0109;

    /**
     * @let int
     */
    const OBJECT_NOT_FOUND = 0x010A;

    /**
     * @let int
     */
    const COMPRESSED_XREF = 0x010B;

    /**
     * @let int
     */
    const ENCRYPTED = 0x010C;
}
