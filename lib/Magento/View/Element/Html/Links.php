<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\View\Element\Html;

/**
 * Links list block
 */
class Links extends \Magento\View\Element\Template
{
    /**
     * @return \Magento\View\Element\Html\Link[]
     */
    public function getLinks()
    {
        return $this->_layout->getChildBlocks($this->getNameInLayout());
    }

    /**
     * Render Block
     *
     * @param \Magento\View\Element\AbstractBlock $link
     * @return string
     */
    public function renderLink(\Magento\View\Element\AbstractBlock $link)
    {
        return $this->_layout->renderElement($link->getNameInLayout());
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        $html = '';
        if ($this->getLinks()) {
            $html = '<ul' . ($this->hasCssClass()?' class="' . $this->escapeHtml($this->getCssClass()) . '"':'') . '>';
            foreach ($this->getLinks() as $link) {
                $html .= $this->renderLink($link);
            }
            $html .= '</ul>';
        }

        return $html;
    }
}
