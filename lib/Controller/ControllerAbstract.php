<?php

/*
 * This file is part of mazarini/tools-bundles.
 *
 * mazarini/tools-bundles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/tools-bundles is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/tools-bundles. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Mazarini\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use UnexpectedValueException;

class ControllerAbstract extends AbstractController
{
    /**
     * @param string $message
     */
    protected function addFlash(string $type, mixed $message): void
    {
        parent::addFlash('message', ['type' => $type, 'message' => $message]);
    }

    protected function getRequestStringValue(string $name, string $default = null): ?string
    {
        $value = $this->getRequest()->get($name);
        if (null === $value) {
            return $default;
        }
        if (\is_string($value)) {
            return (string) $value;
        }
        throw new UnexpectedValueException(sprintf('%s from request isn\'t a string', $name));
    }

    protected function getRequest(): Request
    {
        $request = $this->getRequestStack()->getCurrentRequest();
        if (null !== $request) {
            return $request;
        }
        throw new UnexpectedValueException(sprintf('%s has no request in controller', RequestStack::class));
    }

    protected function getRequestStack(): RequestStack
    {
        $requestStack = $this->container->get('request_stack');
        if (\is_object($requestStack)) {
            if (is_a($requestStack, RequestStack::class)) {
                return $requestStack;
            }
        }
        throw new UnexpectedValueException(sprintf('Container don\'t have a valid "%s"', RequestStack::class));
    }
}
