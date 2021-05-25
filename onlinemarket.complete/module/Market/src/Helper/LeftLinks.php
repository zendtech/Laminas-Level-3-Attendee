<?php
namespace Market\Helper;

use Laminas\View\Helper\AbstractHelper;

class LeftLinks extends AbstractHelper
{
    /*
     * Returns HTML <ul><li><a href="$urlPrefix/$item">$item</li><ul>
     * @param Array $values = array of values to be processed
     * @param string $urlPrefix = prefix to be inserted in front of each array element
     * @return string $html
     */
    public function render($values, $urlPrefix)
    {
        $html = '';
        if (isset($values) && is_array($values)) {
            $html .= '<ul  style="list-style-type: none;">' . PHP_EOL;
            foreach ($values as $item) {
                //*** TRANSLATION LAB: translate categories
                $transItem = $this->getView()->translate($item);
                $html .= str_replace('//', '/', sprintf("<li><a href=\"%s/%s\">%s</a></li>\n", $urlPrefix, $item, $transItem));
            }
            $html .= '</ul>' . PHP_EOL;
        }
        return $html;
    }
    public function __invoke($values, $urlPrefix)
    {
        return $this->render($values, $urlPrefix);
    }
}
