<?php

/*
 * This file is part of StaticReview
 *
 * Copyright (c) 2014 Samuel Parkinson <@samparkinson_>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see http://github.com/sjparkinson/static-review/blob/master/LICENSE
 */

namespace StaticReview\Review;

use StaticReview\File\FileInterface;
use StaticReview\Commit\CommitMessageInterface;
use Symfony\Component\Process\Process;

abstract class AbstractReview implements ReviewInterface
{
    abstract protected function canReviewFile(FileInterface $file);

    abstract protected function canReviewMessage(CommitMessageInterface $message);

    /**
     * Determine if the subject can be reviewed.
     *
     * @param  ReviewableInterface $subject
     * @return boolean
     */
    public function canReview(ReviewableInterface $subject)
    {
        if ($subject instanceof FileInterface) {
            return $this->canReviewFile($subject);
        }
        if ($subject instanceof CommitMessageInterface) {
            return $this->canReviewMessage($subject);
        }
        return false;
    }

    /**
     * @param string      $commandline
     * @param null|string $cwd
     * @param null|array  $env
     * @param null|string $input
     * @param int         $timeout
     * @param array       $options
     *
     * @return Process
     */
    public function getProcess(
        $commandline,
        $cwd = null,
        array $env = null,
        $input = null,
        $timeout = 60,
        array $options = []
    ) {
        return new Process($commandline, $cwd, $env, $input, $timeout, $options);
    }
}
