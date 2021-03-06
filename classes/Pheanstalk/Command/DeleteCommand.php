<?php
namespace Pheanstalk\Command;
use Pheanstalk\Response;

/**
 * The 'delete' command.
 * Permanently deletes an already-reserved job.
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class DeleteCommand
	extends AbstractCommand
	implements \Pheanstalk\ResponseParser
{
	private $_job;

	/**
	 * @param object $job Pheanstalk_Job
	 */
	public function __construct($job)
	{
		$this->_job = $job;
	}

	/* (non-phpdoc)
	 * @see Pheanstalk_Command::getCommandLine()
	 */
	public function getCommandLine()
	{
		return 'delete '.$this->_job->getId();
	}

	/* (non-phpdoc)
	 * @see Pheanstalk_ResponseParser::parseRespose()
	 */
	public function parseResponse($responseLine, $responseData)
	{
		if ($responseLine == Response::RESPONSE_NOT_FOUND)
		{
			throw new \Pheanstalk\Exception\ServerException(sprintf(
				'Cannot delete job %d: %s',
				$this->_job->getId(),
				$responseLine
			));
		}

		return $this->_createResponse($responseLine);
	}
}
