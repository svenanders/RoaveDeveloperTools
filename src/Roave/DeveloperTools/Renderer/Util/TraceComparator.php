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

namespace Roave\DeveloperTools\Renderer\Util;

use Closure;

/**
 * Utility to compare stack traces
 */
class TraceComparator
{
    /**
     * @param array $childTrace
     * @param array $parentTrace
     *
     * @return bool
     */
    public function isChildTrace(array $childTrace, array $parentTrace)
    {
        $childTraceLength  = count($childTrace);
        $parentTraceLength = count($parentTrace);

        if ($childTraceLength <= $parentTraceLength) {
            return false;
        }

        for ($pointer = 1; ($parentTraceLength - $pointer) > 0; $pointer += 1) {
            $parentTraceFrame = $parentTrace[$parentTraceLength - $pointer];
            $childTraceFrame  = $childTrace[$childTraceLength - $pointer];

            if (! (
                $this->compareTraceFrameParam('file', $parentTraceFrame, $childTraceFrame)
                && $this->compareTraceFrameParam('class', $parentTraceFrame, $childTraceFrame)
                && $this->compareTraceFrameParam('function', $parentTraceFrame, $childTraceFrame)
                && $this->compareTraceFrameParam('type', $parentTraceFrame, $childTraceFrame)
                && $this->compareTraceFrameParam('class', $parentTraceFrame, $childTraceFrame)
                && $this->getClass($parentTraceFrame) === $this->getClass($childTraceFrame)
            )) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  array       $traceFrame
     * @return null|string
     */
    private function getClass(array $traceFrame)
    {
        if (isset($traceFrame['object'])) {
            if ($traceFrame['object'] instanceof Closure) {
                return 'Closure';
            }

            return get_class($traceFrame['object']);
        }

        return null;
    }

    /**
     * @param string $paramName
     * @param array  $traceFrame1
     * @param array  $traceFrame2
     *
     * @return bool
     */
    private function compareTraceFrameParam($paramName, array $traceFrame1, array $traceFrame2)
    {
        $param1 = isset($traceFrame1[$paramName]) ? $traceFrame1[$paramName] : null;
        $param2 = isset($traceFrame2[$paramName]) ? $traceFrame2[$paramName] : null;

        return $param1 === $param2;
    }
}
