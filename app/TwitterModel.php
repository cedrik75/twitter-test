<?php

declare(strict_types=1);

use DG\Twitter\Twitter;

class TwitterModel {

	
	public $configs;

	public function __construct(array $configs)
	{
		$this->configs = $configs;
	}

	/**
	 * Connect to Twitter API
	 * * @return Twitter
	 */
	public function getTwitter(): Twitter
	{
		$wittertwitterAuth = $this->configs['twitterAuth'];
		return new Twitter(
			$wittertwitterAuth['consumerKey'], 
			$wittertwitterAuth['consumerSecret'], 
			$wittertwitterAuth['accessToken'], 
			$wittertwitterAuth['accessTokenSecret']
		);	
	}

	/**
	 * Set parameters for search
	 * @return array
	 */
	public function setSearchParameters()
	{
		 return [
			'q' => implode(' OR ', $this->configs['search']) . '-filter:retweets',
			'count' => $this->configs['count'],
			'tweet_mode' => $this->configs['tweet_mode'],
		];
	}

	/**
	 * Get tweets
	 * @return array
	 */
	public function getTweets(): array
	{
		$twitter = $this->getTwitter();
		return $twitter->search($this->setSearchParameters());
	}
	
	/**
	 * Get tweets with filter
	 * @return array
	 */
	public function getTweetsWithFilter(): array
	{
		$twitter = $this->getTwitter();
		$parameters = $this->setSearchParameters();
		$parameters['q'] = $parameters['q'] . '-filter:retweets';
		return $twitter->search($parameters);
	}

	/**
	 * Make twitter links, @usernames and #hashtags clickable
	 * @return array
	 */
	public function getTweetsClickableText(array $results): array
	{
		$tweets = [];
		foreach ($results as $key => $status) {
			$tweets[$key] = Twitter::clickable($status);
		}
		return $tweets;
	}

}

