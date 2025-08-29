<?php

declare(strict_types=1);

namespace Phastron\Tools;

/**
 * High-precision stopwatch for timing operations.
 */
final class Stopwatch
{
    private float $startTime;
    private float $stopTime;
    private bool $isRunning = false;
    private array $laps = [];

    /**
     * Start the stopwatch.
     *
     * @return self
     */
    public function start(): self
    {
        $this->startTime = microtime(true);
        $this->isRunning = true;
        $this->laps = [];
        return $this;
    }

    /**
     * Stop the stopwatch.
     *
     * @return self
     */
    public function stop(): self
    {
        if (!$this->isRunning) {
            throw new \RuntimeException('Stopwatch is not running');
        }
        
        $this->stopTime = microtime(true);
        $this->isRunning = false;
        return $this;
    }

    /**
     * Record a lap time.
     *
     * @param string|null $label Optional lap label
     * @return self
     */
    public function lap(?string $label = null): self
    {
        if (!$this->isRunning) {
            throw new \RuntimeException('Stopwatch is not running');
        }
        
        $currentTime = microtime(true);
        $lapTime = $currentTime - $this->startTime;
        
        $this->laps[] = [
            'time' => $lapTime,
            'label' => $label ?? 'Lap ' . (count($this->laps) + 1),
            'timestamp' => $currentTime,
        ];
        
        return $this;
    }

    /**
     * Reset the stopwatch.
     *
     * @return self
     */
    public function reset(): self
    {
        $this->startTime = 0.0;
        $this->stopTime = 0.0;
        $this->isRunning = false;
        $this->laps = [];
        return $this;
    }

    /**
     * Get elapsed time in seconds.
     *
     * @return float Elapsed time in seconds
     */
    public function getElapsedTime(): float
    {
        if ($this->isRunning) {
            return microtime(true) - $this->startTime;
        }
        
        return $this->stopTime - $this->startTime;
    }

    /**
     * Get elapsed time in milliseconds.
     *
     * @return float Elapsed time in milliseconds
     */
    public function getElapsedMilliseconds(): float
    {
        return $this->getElapsedTime() * 1000;
    }

    /**
     * Get elapsed time in microseconds.
     *
     * @return float Elapsed time in microseconds
     */
    public function getElapsedMicroseconds(): float
    {
        return $this->getElapsedTime() * 1000000;
    }

    /**
     * Get formatted elapsed time.
     *
     * @param int $precision Decimal precision
     * @return string Formatted time string
     */
    public function getFormattedTime(int $precision = 6): string
    {
        $time = $this->getElapsedTime();
        
        if ($time < 0.001) {
            return round($time * 1000000, $precision) . ' μs';
        }
        
        if ($time < 1) {
            return round($time * 1000, $precision) . ' ms';
        }
        
        return round($time, $precision) . ' s';
    }

    /**
     * Get all lap times.
     *
     * @return array Array of lap information
     */
    public function getLaps(): array
    {
        return $this->laps;
    }

    /**
     * Get the fastest lap time.
     *
     * @return array|null Fastest lap or null if no laps
     */
    public function getFastestLap(): ?array
    {
        if (empty($this->laps)) {
            return null;
        }
        
        $fastest = $this->laps[0];
        foreach ($this->laps as $lap) {
            if ($lap['time'] < $fastest['time']) {
                $fastest = $lap;
            }
        }
        
        return $fastest;
    }

    /**
     * Get the slowest lap time.
     *
     * @return array|null Slowest lap or null if no laps
     */
    public function getSlowestLap(): ?array
    {
        if (empty($this->laps)) {
            return null;
        }
        
        $slowest = $this->laps[0];
        foreach ($this->laps as $lap) {
            if ($lap['time'] > $slowest['time']) {
                $slowest = $lap;
            }
        }
        
        return $slowest;
    }

    /**
     * Get average lap time.
     *
     * @return float Average lap time in seconds
     */
    public function getAverageLapTime(): float
    {
        if (empty($this->laps)) {
            return 0.0;
        }
        
        $total = 0.0;
        foreach ($this->laps as $lap) {
            $total += $lap['time'];
        }
        
        return $total / count($this->laps);
    }

    /**
     * Check if stopwatch is running.
     *
     * @return bool True if running
     */
    public function isRunning(): bool
    {
        return $this->isRunning;
    }

    /**
     * Get detailed timing information.
     *
     * @return array Timing statistics
     */
    public function getStats(): array
    {
        $elapsed = $this->getElapsedTime();
        $lapCount = count($this->laps);
        
        $stats = [
            'elapsed_time' => $elapsed,
            'elapsed_milliseconds' => $elapsed * 1000,
            'elapsed_microseconds' => $elapsed * 1000000,
            'is_running' => $this->isRunning,
            'lap_count' => $lapCount,
        ];
        
        if ($lapCount > 0) {
            $stats['fastest_lap'] = $this->getFastestLap();
            $stats['slowest_lap'] = $this->getSlowestLap();
            $stats['average_lap_time'] = $this->getAverageLapTime();
            $stats['all_laps'] = $this->laps;
        }
        
        return $stats;
    }

    /**
     * Create a stopwatch and start it immediately.
     *
     * @return self Running stopwatch
     */
    public static function startNew(): self
    {
        return (new self())->start();
    }

    /**
     * Time a callable and return the result with timing information.
     *
     * @param callable $callable Function to time
     * @param array $args Arguments to pass to the callable
     * @return array Result and timing information
     */
    public static function time(callable $callable, array $args = []): array
    {
        $stopwatch = self::startNew();
        $result = $callable(...$args);
        $stopwatch->stop();
        
        return [
            'result' => $result,
            'timing' => $stopwatch->getStats(),
        ];
    }
}
