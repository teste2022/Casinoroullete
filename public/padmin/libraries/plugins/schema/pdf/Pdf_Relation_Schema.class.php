<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * PDF schema handling
 *
 * @package PhpMyAdmin
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * Skip the plugin if TCPDF is not available.
 */
if (! file_exists(TCPDF_INC)) {
    $GLOBALS['skip_import'] = true;
    return;
}

/**
 * block attempts to directly run this script
 */
if (getcwd() == dirname(__FILE__)) {
    die('Attack stopped');
}

require_once 'libraries/plugins/schema/Export_Relation_Schema.class.php';
require_once 'libraries/plugins/schema/pdf/RelationStatsPdf.class.php';
require_once 'libraries/plugins/schema/pdf/TableStatsPdf.class.php';
require_once 'libraries/PDF.class.php';
require_once 'libraries/transformations.lib.php';

/**
 * Extends the "TCPDF" class and helps
 * in developing the structure of PDF Schema Export
 *
 * @access  public
 * @package PhpMyAdmin
 * @see     TCPDF
 */
class PMA_Schema_PDF extends PMA_PDF
{
    /**
     * Defines properties
     */
    var $_xMin;
    var $_yMin;
    var $leftMargin = 10;
    var $topMargin = 10;
    var $scale;
    var $PMA_links;
    var $Outlines = array();
    var $def_outlines;
    var $widths;
    private $_ff = PMA_PDF_FONT;
    private $_offline;
    private $_pageNumber;
    private $_withDoc;
    private $_db;

    /**
     * Constructs PDF for schema export.
     *
     * @param string  $orientation page orientation
     * @param string  $unit        unit
     * @param string  $paper       the format used for pages
     * @param int     $pageNumber  schema page number that is being exported
     * @param boolean $withDoc     with document dictionary
     * @param string  $db          the database name
     *
     * @access public
     */
    public function __construct(
        $orientation, $unit, $paper, $pageNumber, $withDoc, $db
    ) {
        parent::__construct($orientation, $unit, $paper);
        $this->_pageNumber = $pageNumber;
        $this->_withDoc = $withDoc;
        $this->_db = $db;
    }

    /**
     * Sets the value for margins
     *
     * @param float $c_margin margin
     *
     * @return void
     */
    public function setCMargin($c_margin)
    {
        $this->cMargin = $c_margin;
    }

    /**
     * Sets the scaling factor, defines minimum coordinates and margins
     *
     * @param float|int $scale      The scaling factor
     * @param float|int $xMin       The minimum X coordinate
     * @param float|int $yMin       The minimum Y coordinate
     * @param float|int $leftMargin The left margin
     * @param float|int $topMargin  The top margin
     *
     * @return void
     */
    public function setScale($scale = 1, $xMin = 0, $yMin = 0,
        $leftMargin = -1, $topMargin = -1
    ) {
        $this->scale = $scale;
        $this->_xMin = $xMin;
        $this->_yMin = $yMin;
        if ($this->leftMargin != -1) {
            $this->leftMargin = $leftMargin;
        }
        if ($this->topMargin != -1) {
            $this->topMargin = $topMargin;
        }
    }

    /**
     * Outputs a scaled cell
     *
     * @param float|int $w      The cell width
     * @param float|int $h      The cell height
     * @param string    $txt    The text to output
     * @param mixed     $border Whether to add borders or not
     * @param integer   $ln     Where to put the cursor once the output is done
     * @param string    $align  Align mode
     * @param integer   $fill   Whether to fill the cell with a color or not
     * @param string    $link   Link
     *
     * @return void
     *
     * @see TCPDF::Cell()
     */
    public function cellScale($w, $h = 0, $txt = '', $border = 0, $ln = 0,
        $align = '', $fill = 0, $link = ''
    ) {
        $h = $h / $this->scale;
        $w = $w / $this->scale;
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }

    /**
     * Draws a scaled line
     *
     * @param float $x1 The horizontal position of the starting point
     * @param float $y1 The vertical position of the starting point
     * @param float $x2 The horizontal position of the ending point
     * @param float $y2 The vertical position of the ending point
     *
     * @return void
     *
     * @see TCPDF::Line()
     */
    public function lineScale($x1, $y1, $x2, $y2)
    {
        $x1 = ($x1 - $this->_xMin) / $this->scale + $this->leftMargin;
        $y1 = ($y1 - $this->_yMin) / $this->scale + $this->topMargin;
        $x2 = ($x2 - $this->_xMin) / $this->scale + $this->leftMargin;
        $y2 = ($y2 - $this->_yMin) / $this->scale + $this->topMargin;
        $this->Line($x1, $y1, $x2, $y2);
    }

    /**
     * Sets x and y scaled positions
     *
     * @param float $x The x position
     * @param float $y The y position
     *
     * @return void
     *
     * @see TCPDF::SetXY()
     */
    public function setXyScale($x, $y)
    {
        $x = ($x - $this->_xMin) / $this->scale + $this->leftMargin;
        $y = ($y - $this->_yMin) / $this->scale + $this->topMargin;
        $this->SetXY($x, $y);
    }

    /**
     * Sets the X scaled positions
     *
     * @param float $x The x position
     *
     * @return void
     *
     * @see TCPDF::SetX()
     */
    public function setXScale($x)
    {
        $x = ($x - $this->_xMin) / $this->scale + $this->leftMargin;
        $this->SetX($x);
    }

    /**
     * Sets the scaled font size
     *
     * @param float $size The font size (in points)
     *
     * @return void
     *
     * @see TCPDF::SetFontSize()
     */
    public function setFontSizeScale($size)
    {
        // Set font size in points
        $size = $size / $this->scale;
        $this->SetFontSize($size);
    }

    /**
     * Sets the scaled line width
     *
     * @param float $width The line width
     *
     * @return void
     *
     * @see TCPDF::SetLineWidth()
     */
    public function setLineWidthScale($width)
    {
        $width = $width / $this->scale;
        $this->SetLineWidth($width);
    }

    /**
     * This method is used to render the page header.
     *
     * @return void
     *
     * @see TCPDF::Header()
     */
    public function Header()
    {
        // We only show this if we find something in the new pdf_pages table

        // This function must be named "Header" to work with the TCPDF library
        if ($this->_withDoc) {
            if ($this->_offline || $this->_pageNumber == -1) {
                $pg_name = __("PDF export page");
            } else {
                $test_query = 'SELECT * FROM '
                    . PMA_Util::backquote($GLOBALS['cfgRelation']['db']) . '.'
                    . PMA_Util::backquote($GLOBALS['cfgRelation']['pdf_pages'])
                    . ' WHERE db_name = \'' . PMA_Util::sqlAddSlashes($this->_db)
                    . '\' AND page_nr = \'' . $this->_pageNumber . '\'';
                $test_rs = PMA_queryAsControlUser($test_query);
                $pages = @$GLOBALS['dbi']->fetchAssoc($test_rs);
                $pg_name = ucfirst($pages['page_descr']);
            }

            $this->SetFont($this->_ff, 'B', 14);
            $this->Cell(0, 6, $pg_name, 'B', 1, 'C');
            $this->SetFont($this->_ff, '');
            $this->Ln();
        }
    }

    /**
     * This function must be named "Footer" to work with the TCPDF library
     *
     * @return void
     *
     * @see PMA_PDF::Footer()
     */
    public function Footer()
    {
        if ($this->_withDoc) {
            parent::Footer();
        }
    }

    /**
     * Sets widths
     *
     * @param array $w array of widths
     *
     * @return void
     */
    public function SetWidths($w)
    {
        // column widths
        $this->widths = $w;
    }

    /**
     * Generates table row.
     *
     * @param array $data  Data for table
     * @param array $links Links for table cells
     *
     * @return void
     */
    public function Row($data, $links)
    {
        // line height
        $nb = 0;
        $data_cnt = count($data);
        for ($i = 0;$i < $data_cnt;$i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $il = $this->FontSize;
        $h = ($il + 1) * $nb;
        // page break if necessary
        $this->CheckPageBreak($h);
        // draw the cells
        $data_cnt = count($data);
        for ($i = 0;$i < $data_cnt;$i++) {
            $w = $this->widths[$i];
            // save current position
            $x = $this->GetX();
            $y = $this->GetY();
            // draw the border
            $this->Rect($x, $y, $w, $h);
            if (isset($links[$i])) {
                $this->Link($x, $y, $w, $h, $links[$i]);
            }
            // print text
            $this->MultiCell($w, $il + 1, $data[$i], 0, 'L');
            // go to right side
            $this->SetXY($x + $w, $y);
        }
        // go to line
        $this->Ln($h);
    }

    /**
     * Compute number of lines used by a multicell of width w
     *
     * @param int    $w   width
     * @param string $txt text
     *
     * @return int
     */
    public function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w-2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = /*overload*/mb_strlen($s);
        if ($nb > 0 and $s[$nb-1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += isset($cw[/*overload*/mb_ord($c)])?$cw[/*overload*/mb_ord($c)]:0 ;
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    /**
     * Set whether the document is generated from client side DB
     *
     * @param string $value whether offline
     *
     * @return void
     *
     * @access private
     */
    public function setOffline($value)
    {
        $this->_offline = $value;
    }
}

/**
 * Pdf Relation Schema Class
 *
 * Purpose of this class is to generate the PDF Document. PDF is widely
 * used format for documenting text,fonts,images and 3d vector graphics.
 *
 * This class inherits Export_Relation_Schema class has common functionality added
 * to this class
 *
 * @name Pdf_Relation_Schema
 * @package PhpMyAdmin
 */
class PMA_Pdf_Relation_Schema extends PMA_Export_Relation_Schema
{
    /**
     * Defines properties
     */
    private $_showGrid;
    private $_withDoc;
    private $_tableOrder;

    /**
     * @var Table_Stats_Pdf[]
     */
    private $_tables = array();
    private $_ff = PMA_PDF_FONT;
    private $_xMax = 0;
    private $_yMax = 0;
    private $_scale;
    private $_xMin = 100000;
    private $_yMin = 100000;
    private $_topMargin = 10;
    private $_bottomMargin = 10;
    private $_leftMargin = 10;
    private $_rightMargin = 10;
    private $_tablewidth;

    /**
     * @var Relation_Stats_Pdf[]
     */
    protected $relations = array();

    /**
     * The "PMA_Pdf_Relation_Schema" constructor
     *
     * @param string $db database name
     *
     * @see PMA_Schema_PDF
     */
    public function __construct($db)
    {
        $this->setShowGrid(isset($_REQUEST['pdf_show_grid']));
        $this->setShowColor(isset($_REQUEST['pdf_show_color']));
        $this->setShowKeys(isset($_REQUEST['pdf_show_keys']));
        $this->setTableDimension(isset($_REQUEST['pdf_show_table_dimension']));
        $this->setAllTablesSameWidth(isset($_REQUEST['pdf_all_tables_same_width']));
        $this->setWithDataDictionary(isset($_REQUEST['pdf_with_doc']));
        $this->setTableOrder($_REQUEST['pdf_table_order']);
        $this->setOrientation($_REQUEST['pdf_orientation']);
        $this->setPaper($_REQUEST['pdf_paper']);

        // Initializes a new document
        parent::__construct(
            $db,
            new PMA_Schema_PDF(
                $this->orientation, 'mm', $this->paper,
                $this->pageNumber, $this->_withDoc, $db
            )
        );
        $this->diagram->SetTitle(
            sprintf(
                __('Schema of the %s database'),
                $this->db
            )
        );
        $this->diagram->setCMargin(0);
        $this->diagram->Open();
        $this->diagram->SetAutoPageBreak('auto');
        $this->diagram->setOffline($this->offline);

        $alltables = $this->getTablesFromRequest();
        if ($this->getTableOrder() == 'name_asc') {
            sort($alltables);
        } else if ($this->getTableOrder() == 'name_desc') {
            rsort($alltables);
        }

        if ($this->_withDoc) {
            $this->diagram->SetAutoPageBreak('auto', 15);
            $this->diagram->setCMargin(1);
            $this->dataDictionaryDoc($alltables);
            $this->diagram->SetAutoPageBreak('auto');
            $this->diagram->setCMargin(0);
        }

        $this->diagram->Addpage();

        if ($this->_withDoc) {
            $this->diagram->SetLink($this->diagram->PMA_links['RT']['-'], -1);
            $this->diagram->Bookmark(__('Relational schema'));
            $this->diagram->SetAlias('{00}', $this->diagram->PageNo());
            $this->_topMargin = 28;
            $this->_bottomMargin = 28;
        }

        /* snip */
        foreach ($alltables as $table) {
            if (! isset($this->_tables[$table])) {
                $this->_tables[$table] = new Table_Stats_Pdf(
                    $this->diagram,
                    $this->db,
                    $table,
                    null,
                    $this->pageNumber,
                    $this->_tablewidth,
                    $this->showKeys,
                    $this->tableDimension,
                    $this->offline
                );
            }
            if ($this->sameWide) {
                $this->_tables[$table]->width = $this->_tablewidth;
            }
            $this->_setMinMax($this->_tables[$table]);
        }

        // Defines the scale factor
        $innerWidth = $this->diagram->getPageWidth() - $this->_rightMargin
            - $this->_leftMargin;
        $innerHeight = $this->diagram->getPageHeight() - $this->_topMargin
            - $this->_bottomMargin;
        $this->_scale = ceil(
            max(
                ($this->_xMax - $this->_xMin) / $innerWidth,
                ($this->_yMax - $this->_yMin) / $innerHeight
            ) * 100
        ) / 100;

        $this->diagram->setScale(
            $this->_scale,
            $this->_xMin,
            $this->_yMin,
            $this->_leftMargin,
            $this->_topMargin
        );
        // Builds and save the PDF document
        $this->diagram->setLineWidthScale(0.1);

        if ($this->_showGrid) {
            $this->diagram->SetFontSize(10);
            $this->_strokeGrid();
        }
        $this->diagram->setFontSizeScale(14);
        // previous logic was checking master tables and foreign tables
        // but I think that looping on every table of the pdf page as a master
        // and finding its foreigns is OK (then we can support innodb)
        $seen_a_relation = false;
        foreach ($alltables as $one_table) {
            $exist_rel = PMA_getForeigners($this->db, $one_table, '', 'both');
            if (!$exist_rel) {
                continue;
            }

            $seen_a_relation = true;
            foreach ($exist_rel as $master_field => $rel) {
                // put the foreign table on the schema only if selected
                // by the user
                // (do not use array_search() because we would have to
                // to do a === false and this is not PHP3 compatible)
                if ($master_field != 'foreign_keys_data') {
                    if (in_array($rel['foreign_table'], $alltables)) {
                        $this->_addRelation(
                            $one_table,
                            $master_field,
                            $rel['foreign_table'],
                            $rel['foreign_field']
                        );
                    }
                    continue;
                }

                foreach ($rel as $one_key) {
                    if (!in_array($one_key['ref_table_name'], $alltables)) {
                        continue;
                    }

                    foreach ($one_key['index_list']
                        as $index => $one_field
                    ) {
                        $this->_addRelation(
                            $one_table,
                            $one_field,
                            $one_key['ref_table_name'],
                            $one_key['ref_index_list'][$index]
                        );
                    }
                }
            } // end while
        } // end while

        if ($seen_a_relation) {
            $this->_drawRelations();
        }
        $this->_drawTables();
    }

    /**
     * Set Show Grid
     *
     * @param boolean $value show grid of the document or not
     *
     * @return void
     */
    public function setShowGrid($value)
    {
        $this->_showGrid = $value;
    }

    /**
     * Returns whether to show grid
     *
     * @return boolean whether to show grid
     */
    public function isShowGrid()
    {
        return $this->_showGrid;
    }

    /**
     * Set Data Dictionary
     *
     * @param boolean $value show selected database data dictionary or not
     *
     * @return void
     */
    public function setWithDataDictionary($value)
    {
        $this->_withDoc = $value;
    }

    /**
     * Return whether to show selected database data dictionary or not
     *
     * @return boolean whether to show selected database data dictionary or not
     */
    public function isWithDataDictionary()
    {
        return $this->_withDoc;
    }

    /**
     * Sets the order of the table in data dictionary
     *
     * @param string $value table order
     *
     * @return void
     */
    public function setTableOrder($value)
    {
        $this->_tableOrder = $value;
    }

    /**
     * Returns the order of the table in data dictionary
     *
     * @return string table order
     */
    public function getTableOrder()
    {
        return $this->_tableOrder;
    }

    /**
     * Output Pdf Document for download
     *
     * @return void
     */
    public function showOutput()
    {
        $this->diagram->Download($this->getFileName('.pdf'));
    }

    /**
     * Sets X and Y minimum and maximum for a table cell
     *
     * @param Table_Stats_Pdf $table The table name of which sets XY co-ordinates
     *
     * @return void
     */
    private function _setMinMax($table)
    {
        $this->_xMax = max($this->_xMax, $table->x + $table->width);
        $this->_yMax = max($this->_yMax, $table->y + $table->height);
        $this->_xMin = min($this->_xMin, $table->x);
        $this->_yMin = min($this->_yMin, $table->y);
    }

    /**
     * Defines relation objects
     *
     * @param string $masterTable  The master table name
     * @param string $masterField  The relation field in the master table
     * @param string $foreignTable The foreign table name
     * @param string $foreignField The relation field in the foreign table
     *
     * @return void
     *
     * @see _setMinMax
     */
    private function _addRelation($masterTable, $masterField, $foreignTable,
        $foreignField
    ) {
        if (! isset($this->_tables[$masterTable])) {
            $this->_tables[$masterTable] = new Table_Stats_Pdf(
                $this->diagram,
                $this->db,
                $masterTable,
                null,
                $this->pageNumber,
                $this->_tablewidth,
                $this->showKeys,
                $this->tableDimension
            );
            $this->_setMinMax($this->_tables[$masterTable]);
        }
        if (! isset($this->_tables[$foreignTable])) {
            $this->_tables[$foreignTable] = new Table_Stats_Pdf(
                $this->diagram,
                $this->db,
                $foreignTable,
                null,
                $this->pageNumber,
                $this->_tablewidth,
                $this->showKeys,
                $this->tableDimension
            );
            $this->_setMinMax($this->_tables[$foreignTable]);
        }
        $this->relations[] = new Relation_Stats_Pdf(
            $this->diagram,
            $this->_tables[$masterTable],
            $masterField,
            $this->_tables[$foreignTable],
            $foreignField
        );
    }

    /**
     * Draws the grid
     *
     * @return void
     *
     * @see PMA_Schema_PDF
     */
    private function _strokeGrid()
    {
        $gridSize = 10;
        $labelHeight = 4;
        $labelWidth = 5;
        if ($this->_withDoc) {
            $topSpace = 6;
            $bottomSpace = 15;
        } else {
            $topSpace = 0;
            $bottomSpace = 0;
        }

        $this->diagram->SetMargins(0, 0);
        $this->diagram->SetDrawColor(200, 200, 200);
        // Draws horizontal lines
        $innerHeight = $this->diagram->getPageHeight() - $topSpace - $bottomSpace;
        for ($l = 0,
            $size = intval($innerHeight / $gridSize);
            $l <= $size;
            $l++
        ) {
            $this->diagram->line(
                0, $l * $gridSize + $topSpace,
                $this->diagram->getPageWidth(), $l * $gridSize + $topSpace
            );
            // Avoid duplicates
            if ($l > 0
                && $l <= intval(($innerHeight - $labelHeight) / $gridSize)
            ) {
                $this->diagram->SetXY(0, $l * $gridSize + $topSpace);
                $label = (string) sprintf(
                    '%.0f',
                    ($l * $gridSize + $topSpace - $this->_topMargin)
                    * $this->_scale + $this->_yMin
                );
                $this->diagram->Cell($labelWidth, $labelHeight, ' ' . $label);
            } // end if
        } // end for
        // Draws vertical lines
        for (
            $j = 0, $size = intval($this->diagram->getPageWidth() / $gridSize);
            $j <= $size;
            $j++
        ) {
            $this->diagram->line(
                $j * $gridSize,
                $topSpace,
                $j * $gridSize,
                $this->diagram->getPageHeight() - $bottomSpace
            );
            $this->diagram->SetXY($j * $gridSize, $topSpace);
            $label = (string) sprintf(
                '%.0f',
                ($j * $gridSize - $this->_leftMargin) * $this->_scale + $this->_xMin
            );
            $this->diagram->Cell($labelWidth, $labelHeight, $label);
        }
    }

    /**
     * Draws relation arrows
     *
     * @return void
     *
     * @see Relation_Stats_Pdf::relationdraw()
     */
    private function _drawRelations()
    {
        $i = 0;
        foreach ($this->relations as $relation) {
            $relation->relationDraw($this->showColor, $i);
            $i++;
        }
    }

    /**
     * Draws tables
     *
     * @return void
     *
     * @see Table_Stats_Pdf::tableDraw()
     */
    private function _drawTables()
    {
        foreach ($this->_tables as $table) {
            $table->tableDraw(null, $this->_withDoc, $this->showColor);
        }
    }

    /**
     * Generates data dictionary pages.
     *
     * @param array $alltables Tables to document.
     *
     * @return void
     */
    public function dataDictionaryDoc($alltables)
    {
         // TOC
        $this->diagram->addpage($this->orientation);
        $this->diagram->Cell(0, 9, __('Table of contents'), 1, 0, 'C');
        $this->diagram->Ln(15);
        $i = 1;
        foreach ($alltables as $table) {
            $this->diagram->PMA_links['doc'][$table]['-']
                = $this->diagram->AddLink();
            $this->diagram->SetX(10);
            // $this->diagram->Ln(1);
            $this->diagram->Cell(
                0, 6, __('Page number:') . ' {' . sprintf("%02d", $i) . '}', 0, 0,
                'R', 0, $this->diagram->PMA_links['doc'][$table]['-']
            );
            $this->diagram->SetX(10);
            $this->diagram->Cell(
                0, 6, $i . ' ' . $table, 0, 1,
                'L', 0, $this->diagram->PMA_links['doc'][$table]['-']
            );
            // $this->diagram->Ln(1);
            $fields = $GLOBALS['dbi']->getColumns($this->db, $table);
            foreach ($fields as $row) {
                $this->diagram->SetX(20);
                $field_name = $row['Field'];
                $this->diagram->PMA_links['doc'][$table][$field_name]
                    = $this->diagram->AddLink();
                //$this->diagram->Cell(
                //    0, 6, $field_name, 0, 1,
                //    'L', 0, $this->diagram->PMA_links['doc'][$table][$field_name]
                //);
            }
            $i++;
        }
        $this->diagram->PMA_links['RT']['-'] = $this->diagram->AddLink();
        $this->diagram->SetX(10);
        $this->diagram->Cell(
            0, 6, __('Page number:') . ' {00}', 0, 0,
            'R', 0, $this->diagram->PMA_links['RT']['-']
        );
        $this->diagram->SetX(10);
        $this->diagram->Cell(
            0, 6, $i . ' ' . __('Relational schema'), 0, 1,
            'L', 0, $this->diagram->PMA_links['RT']['-']
        );
        $z = 0;
        foreach ($alltables as $table) {
            $z++;
            $this->diagram->SetAutoPageBreak(true, 15);
            $this->diagram->addpage($this->orientation);
            $this->diagram->Bookmark($table);
            $this->diagram->SetAlias(
                '{' . sprintf("%02d", $z) . '}', $this->diagram->PageNo()
            );
            $this->diagram->PMA_links['RT'][$table]['-']
                = $this->diagram->AddLink();
            $this->diagram->SetLink(
                $this->diagram->PMA_links['doc'][$table]['-'], -1
            );
            $this->diagram->SetFont($this->_ff, 'B', 18);
            $this->diagram->Cell(
                0, 8, $z . ' ' . $table, 1, 1,
                'C', 0, $this->diagram->PMA_links['RT'][$table]['-']
            );
            $this->diagram->SetFont($this->_ff, '', 8);
            $this->diagram->ln();

            $cfgRelation = PMA_getRelationsParam();
            $comments = PMA_getComments($this->db, $table);
            if ($cfgRelation['mimework']) {
                $mime_map = PMA_getMIME($this->db, $table, true);
            }

            /**
             * Gets table information
             */
            $showtable = $GLOBALS['dbi']->getTable($this->db, $table)
                ->getStatusInfo();
            $show_comment = isset($showtable['Comment'])
                ? $showtable['Comment']
                : '';
            $create_time  = isset($showtable['Create_time'])
                ? PMA_Util::localisedDate(
                    strtotime($showtable['Create_time'])
                )
                : '';
            $update_time  = isset($showtable['Update_time'])
                ? PMA_Util::localisedDate(
                    strtotime($showtable['Update_time'])
                )
                : '';
            $check_time   = isset($showtable['Check_time'])
                ? PMA_Util::localisedDate(
                    strtotime($showtable['Check_time'])
                )
                : '';

            /**
             * Gets fields properties
             */
            $columns = $GLOBALS['dbi']->getColumns($this->db, $table);

            // Find which tables are related with the current one and write it in
            // an array
            $res_rel = PMA_getForeigners($this->db, $table);

            /**
             * Displays the comments of the table if MySQL >= 3.23
             */

            $break = false;
            if (! empty($show_comment)) {
                $this->diagram->Cell(
                    0, 3, __('Table comments:') . ' ' . $show_comment, 0, 1
                );
                $break = true;
            }

            if (! empty($create_time)) {
                $this->diagram->Cell(
                    0, 3, __('Creation:') . ' ' . $create_time, 0, 1
                );
                $break = true;
            }

            if (! empty($update_time)) {
                $this->diagram->Cell(
                    0, 3, __('Last update:') . ' ' . $update_time, 0, 1
                );
                $break = true;
            }

            if (! empty($check_time)) {
                $this->diagram->Cell(
                    0, 3, __('Last check:') . ' ' . $check_time, 0, 1
                );
                $break = true;
            }

            if ($break == true) {
                $this->diagram->Cell(0, 3, '', 0, 1);
                $this->diagram->Ln();
            }

            $this->diagram->SetFont($this->_ff, 'B');
            if (isset($this->orientation) && $this->orientation == 'L') {
                $this->diagram->Cell(25, 8, __('Column'), 1, 0, 'C');
                $this->diagram->Cell(20, 8, __('Type'), 1, 0, 'C');
                $this->diagram->Cell(20, 8, __('Attributes'), 1, 0, 'C');
                $this->diagram->Cell(10, 8, __('Null'), 1, 0, 'C');
                $this->diagram->Cell(20, 8, __('Default'), 1, 0, 'C');
                $this->diagram->Cell(25, 8, __('Extra'), 1, 0, 'C');
                $this->diagram->Cell(45, 8, __('Links to'), 1, 0, 'C');

                if ($this->paper == 'A4') {
                    $comments_width = 67;
                } else {
                    // this is really intended for 'letter'
                    /**
                     * @todo find optimal width for all formats
                     */
                    $comments_width = 50;
                }
                $this->diagram->Cell($comments_width, 8, __('Comments'), 1, 0, 'C');
                $this->diagram->Cell(45, 8, 'MIME', 1, 1, 'C');
                $this->diagram->SetWidths(
                    array(25, 20, 20, 10, 20, 25, 45, $comments_width, 45)
                );
            } else {
                $this->diagram->Cell(20, 8, __('Column'), 1, 0, 'C');
                $this->diagram->Cell(20, 8, __('Type'), 1, 0, 'C');
                $this->diagram->Cell(20, 8, __('Attributes'), 1, 0, 'C');
                $this->diagram->Cell(10, 8, __('Null'), 1, 0, 'C');
                $this->diagram->Cell(15, 8, __('Default'), 1, 0, 'C');
                $this->diagram->Cell(15, 8, __('Extra'), 1, 0, 'C');
                $this->diagram->Cell(30, 8, __('Links to'), 1, 0, 'C');
                $this->diagram->Cell(30, 8, __('Comments'), 1, 0, 'C');
                $this->diagram->Cell(30, 8, 'MIME', 1, 1, 'C');
                $this->diagram->SetWidths(array(20, 20, 20, 10, 15, 15, 30, 30, 30));
            }
            $this->diagram->SetFont($this->_ff, '');

            foreach ($columns as $row) {
                $extracted_columnspec
                    = PMA_Util::extractColumnSpec($row['Type']);
                $type                = $extracted_columnspec['print_type'];
                $attribute           = $extracted_columnspec['attribute'];
                if (! isset($row['Default'])) {
                    if ($row['Null'] != '' && $row['Null'] != 'NO') {
                        $row['Default'] = 'NULL';
                    }
                }
                $field_name = $row['Field'];
                // $this->diagram->Ln();
                $this->diagram->PMA_links['RT'][$table][$field_name]
                    = $this->diagram->AddLink();
                $this->diagram->Bookmark($field_name, 1, -1);
                $this->diagram->SetLink(
                    $this->diagram->PMA_links['doc'][$table][$field_name], -1
                );
                $foreigner = PMA_searchColumnInForeigners($res_rel, $field_name);

                $linksTo = '';
                if ($foreigner) {
                    $linksTo = '-> ';
                    if ($foreigner['foreign_db'] != $this->db) {
                        $linksTo .= $foreigner['foreign_db'] . '.';
                    }
                    $linksTo .= $foreigner['foreign_table']
                        . '.' . $foreigner['foreign_field'];

                    if (isset($foreigner['on_update'])) { // not set for internal
                        $linksTo .= "\n" . 'ON UPDATE ' . $foreigner['on_update'];
                        $linksTo .= "\n" . 'ON DELETE ' . $foreigner['on_delete'];
                    }
                }

                $this->diagram_row = array(
                    $field_name,
                    $type,
                    $attribute,
                    (($row['Null'] == '' || $row['Null'] == 'NO')
                        ? __('No')
                        : __('Yes')),
                    (isset($row['Default']) ? $row['Default'] : ''),
                    $row['Extra'],
                    $linksTo,
                    (isset($comments[$field_name])
                        ? $comments[$field_name]
                        : ''),
                    (isset($mime_map) && isset($mime_map[$field_name])
                        ? str_replace('_', '/', $mime_map[$field_name]['mimetype'])
                        : '')
                );
                $links = array();
                $links[0] = $this->diagram->PMA_links['RT'][$table][$field_name];
                if ($foreigner
                    && isset($this->diagram->PMA_links['doc'][$foreigner['foreign_table']][$foreigner['foreign_field']])
                ) {
                    $links[6] = $this->diagram->PMA_links['doc']
                        [$foreigner['foreign_table']][$foreigner['foreign_field']];
                } else {
                    unset($links[6]);
                }
                $this->diagram->Row($this->diagram_row, $links);
            } // end foreach
            $this->diagram->SetFont($this->_ff, '', 14);
        } //end each
    }
}
