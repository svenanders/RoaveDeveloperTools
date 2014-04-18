<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Roave\DeveloperTools\Mvc\Factory;

use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Repository\FileInspectionRepository;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible for instantiating a {@see \Roave\DeveloperTools\Mvc\Repository\FileInspectionRepository}
 * that stores application-related inspections
 */
class ApplicationInspectionRepositoryFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ApplicationInspectorListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FileInspectionRepository(
            $serviceLocator->get('Config')['roave_developer_tools']['inspections_persistence_dir']
        );
    }
}
