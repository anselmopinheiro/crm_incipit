<?php

namespace App\Queue;

use App\Support\Uuid;
use Illuminate\Queue\DatabaseQueue;

class UuidDatabaseQueue extends DatabaseQueue
{
    /**
     * Push a new job onto the queue.
     *
     * @param  string|null  $queue
     * @param  string  $payload
     * @param  \DateTimeInterface|\DateInterval|int  $delay
     * @param  int  $attempts
     * @return string
     */
    protected function pushToDatabase($queue, $payload, $delay = 0, $attempts = 0)
    {
        $id = Uuid::v7();

        $this->database->table($this->table)->insert(
            $this->buildDatabaseRecord(
                $id,
                $queue,
                $payload,
                $this->availableAt($delay),
                $attempts
            )
        );

        return $id;
    }

    /**
     * Build an array to insert for the database queue.
     *
     * @param  string  $id
     * @param  string|null  $queue
     * @param  string  $payload
     * @param  int  $availableAt
     * @param  int  $attempts
     * @return array
     */
    protected function buildDatabaseRecord($id, $queue, $payload, $availableAt, $attempts = 0)
    {
        return array_merge(
            parent::buildDatabaseRecord($queue, $payload, $availableAt, $attempts),
            ['id' => $id]
        );
    }
}
