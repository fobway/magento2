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

namespace Magento\View\Design\Theme\Image;

/**
 * Theme Image Uploader
 */
class Uploader
{
    /**
     * Allowed file extensions to upload
     *
     * @var array
     */
    protected  $_allowedExtensions = array('jpg', 'jpeg', 'gif', 'png', 'xbm', 'wbmp');

    /**
     * @var \Magento\App\Filesystem
     */
    protected $_filesystem;

    /**
     * @var \Zend_File_Transfer_Adapter_Http
     */
    protected $_transferAdapter;

    /**
     * @var \Magento\File\UploaderFactory
     */
    protected $_uploaderFactory;

    /**
     * @param \Magento\App\Filesystem $filesystem
     * @param \Magento\HTTP\Adapter\FileTransferFactory $adapterFactory
     * @param \Magento\File\UploaderFactory $uploaderFactory
     */
    public function __construct(
        \Magento\App\Filesystem $filesystem,
        \Magento\HTTP\Adapter\FileTransferFactory $adapterFactory,
        \Magento\File\UploaderFactory $uploaderFactory
    ) {
        $this->_filesystem = $filesystem;
        $this->_transferAdapter = $adapterFactory->create();
        $this->_uploaderFactory = $uploaderFactory;
    }

    /**
     * Upload preview image
     *
     * @param string $scope the request key for file
     * @param string $destinationPath path to upload directory
     * @return bool
     * @throws \Magento\Exception
     */
    public function uploadPreviewImage($scope, $destinationPath)
    {
        if (!$this->_transferAdapter->isUploaded($scope)) {
            return false;
        }
        if (!$this->_transferAdapter->isValid($scope)) {
            throw new \Magento\Exception(__('Uploaded image is not valid'));
        }
        $upload = $this->_uploaderFactory->create(array('fileId' => $scope));
        $upload->setAllowCreateFolders(true);
        $upload->setAllowedExtensions($this->_allowedExtensions);
        $upload->setAllowRenameFiles(true);
        $upload->setFilesDispersion(false);

        if (!$upload->checkAllowedExtension($upload->getFileExtension())) {
            throw new \Magento\Exception(__('Invalid image file type.'));
        }
        if (!$upload->save($destinationPath)) {
            throw new \Magento\Exception(__('Image can not be saved.'));
        }
        return $destinationPath . '/' . $upload->getUploadedFileName();
    }
}
