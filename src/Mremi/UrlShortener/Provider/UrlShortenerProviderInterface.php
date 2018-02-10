<?php

/*
 * This file is part of the Pixxet\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pixxet\UrlShortener\Provider;

use Pixxet\UrlShortener\Model\LinkInterface;

/**
 * Url shortener provider interface.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface UrlShortenerProviderInterface
{
    /**
     * Gets the provider name.
     *
     * @return string
     */
    public function getName();

    /**
     * Shortens the long given URL.
     *
     * @param LinkInterface $link A link instance
     *
     * @throws \Pixxet\UrlShortener\Exception\InvalidApiResponseException
     */
    public function shorten(LinkInterface $link);

    /**
     * Expands the short given URL.
     *
     * @param LinkInterface $link A link instance
     *
     * @throws \Pixxet\UrlShortener\Exception\InvalidApiResponseException
     */
    public function expand(LinkInterface $link);
}
