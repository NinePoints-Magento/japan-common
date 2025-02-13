<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace CommunityEngineering\JapaneseAddress\Plugin\Customer\Block\Form;

use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\AbstractBlock;
use CommunityEngineering\JapaneseAddress\Model\Config\CountryInputConfig;

/**
 * Modify address form to show or hide country field.
 */
class CountryFieldVisibility
{
    /**
     * @var ResolverInterface
     */
    protected $localeResolver;

    /**
     * @var CountryInputConfig
     */
    private $countryFieldConfig;

    /**
     * @param \CommunityEngineering\JapaneseAddress\Model\Config\CountryInputConfig $countryFieldConfig
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     */
    public function __construct(
        CountryInputConfig $countryFieldConfig,
        ResolverInterface $localeResolver
    ) {
        $this->localeResolver = $localeResolver;
        $this->countryFieldConfig = $countryFieldConfig;
    }

    /**
     * Modify HTML with country field after block rendering.
     *
     * @param AbstractBlock $block
     * @param string $html
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterToHtml(AbstractBlock $block, $html)
    {
        if ($this->countryFieldConfig->isVisibleAtStorefront() || $this->localeResolver->getLocale() !== 'ja_JP') {
            return $html;
        }

        $hidingCssHack = 'style="display:none;visibility:hidden;height:0px;padding:0px;margin:0px;"';
        return str_replace(
            ['class="field country required"', 'id="country"'],
            ['class="field country required" ' . $hidingCssHack, 'id="country" readonly'],
            $html
        );
    }
}
