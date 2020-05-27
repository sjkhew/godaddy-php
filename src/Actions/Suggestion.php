<?php


namespace Tafhyseni\PhpGodaddy\Actions;


use Tafhyseni\PhpGodaddy\Exceptions\DomainException;
use Tafhyseni\PhpGodaddy\Request\Requests;

class Suggestion extends Requests
{
    /**
     * Method Endpoint
     */
    const URL_SUGGEST_DOMAIN = 'v1/domains/suggest?query=';

    /**
     * Keyword parameter used as searching through suggestions
     * @var string
     */
    public $keyword;

    /**
     * Limit suggestions output
     * @var integer
     */
    public $limit;

    /**
     * @param string $keyword
     * @return Suggestion
     * @throws DomainException
     */
    public function setKeyword(string $keyword): self
    {
        if(!$keyword)
        {
            throw DomainException::noKeywordProvided();
        }

        $this->keyword = $keyword;
        return $this;
    }

    /**
     * Limit suggestions
     * @param int $limit
     * @return Suggestion
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function fetch(): self
    {
        $this->doAPIRequest(
            $this->_prepareEndpoint()
        );

        return $this;
    }

    protected function _prepareEndpoint(): string
    {
        if($this->limit)
        {
            return self::URL_SUGGEST_DOMAIN . $this->keyword . '&limit=' . $this->limit;
        }
        return self::URL_SUGGEST_DOMAIN . $this->keyword;
    }
}