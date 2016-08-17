<?php

/**
 * DataColumn class file.
 * Extends {@link CDataColumn}
 */
class DataColumn extends CDataColumn {

    /**
     * @var boolean whether the htmlOptions values should be evaluated. 
     */
    public $evaluateHtmlOptions = false;

    /**
     * Renders a data cell.
     * @param integer $row the row number (zero-based)
     * Overrides the method 'renderDataCell()' of the abstract class CGridColumn
     */
    public function renderDataCell($row) {
        $data = $this->grid->dataProvider->data[$row];
        //Yii::log("", $level)
        if ($this->evaluateHtmlOptions) {
            foreach ($this->htmlOptions as $key => $value) {
                $options[$key] = $this->evaluateExpression($value, array('row' => $row, 'data' => $data));
            }
        } else
            $options = $this->htmlOptions;
        if ($this->cssClassExpression !== null) {
            $class = $this->evaluateExpression($this->cssClassExpression, array('row' => $row, 'data' => $data));
            if (isset($options['class']))
                $options['class'].=' ' . $class;
            else
                $options['class'] = $class;
        }
        echo CHtml::openTag('td', $options);
        try {
                $this->renderDataCellContent($row, $data);
        } catch (Exception $e) {
            Yii::trace('pb row' + $row + 'data' + $data + 'Exception reçue : ' + $e->getMessage(), CLogger::LEVEL_ERROR);
        }

        echo '</td>';
    }

}

?>