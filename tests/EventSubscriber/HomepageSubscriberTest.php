<?php

/*
 * Copyright (C) 2019-2020 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/tools-bundle.
 *
 * mazarini/tools-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/tools-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace App\Tests\EventSubscriber;

use App\Kernel;
use Mazarini\ToolsBundle\EventSubscriber\HomepageSubscriber;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomepageSubscriberTest extends TestCase
{
    /**
     * testHomepageSubscriber.
     *
     * @dataProvider getTestCase
     */
    public function testHomepageSubscriber(string $homepage, string $pathInfo, \Throwable $exception, bool $redirect): void
    {
        $subscriber = new HomepageSubscriber($homepage);
        $request = new Request();
        $this->setObject($request, ['pathInfo' => $pathInfo]);
        $exceptionEvent = new ExceptionEvent(new Kernel('test', false), $request, 1, $exception);
        $subscriber = new HomepageSubscriber($homepage);
        $subscriber->OnKernelException($exceptionEvent);
        $response = $exceptionEvent->getResponse();
        if ($redirect) {
            $this->assertTrue($response instanceof RedirectResponse);
            if ($response instanceof RedirectResponse) {
                $this->assertSame(Response::HTTP_MOVED_PERMANENTLY, $response->getStatusCode());
                $this->assertSame($homepage, $response->getTargetUrl());
            }
        } else {
            $this->assertNull($response);
        }
    }

    /**
     * getUrls.
     *
     * @return \Traversable<int,array>
     */
    public function getTestCase(): \Traversable
    {
        yield ['/exemple', '/', new NotFoundHttpException(), true];        // redirect to /exemple
        yield ['/', '/', new NotFoundHttpException(), false];              // not redirect to /
        yield ['/exemple', '/toto', new NotFoundHttpException(), false];   // not homepage "/"
        yield ['/exemple', '/', new AccessDeniedHttpException(), false];   // not 404
    }

    /**
     * setObject.
     *
     * @param array<string,mixed> $options
     */
    private function setObject(object $object, array $options): void
    {
        $reflectionClass = new ReflectionClass(\get_class($object));
        foreach ($options as $property => $value) {
            $reflectionProperty = $reflectionClass->getProperty($property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($object, $value);
        }
    }
}
