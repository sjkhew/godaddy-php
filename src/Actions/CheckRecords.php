<?php

namespace Tafhyseni\PhpGodaddy\Actions;

use Tafhyseni\PhpGodaddy\Exceptions\DomainException;
use Tafhyseni\PhpGodaddy\Request\Requests;

class CheckRecords extends Requests
{
    const API_URL = 'v1/domains/{domain}/records/{type}/{name}';

    public $domain;
    public $type;
    public $name;

    /**
     * @param mixed $domain
     * @return CheckRecords
     * @throws DomainException
     */
    public function setDomain(string $domain): self
    {
        if (! $domain) {
            throw DomainException::noDomainProvided();
        }

        $this->domain = MyDomain::parse($domain)->getRegistrableDomain();

        return $this;
    }

    /**
     * @param mixed $type
     * @return CheckRecords
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param mixed $name
     * @return CheckRecords
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function set(): self
    {
        self::doAPICheckRecords($this->endpoint(), $this->type, $this->name);

        return $this;
    }

    protected function endpoint()
    {
        $slugs = ['{domain}', '{type}', '{name}'];
        $parameters = [$this->domain, $this->type, $this->name];

        return str_replace($slugs, $parameters, self::API_URL);
    }
}
