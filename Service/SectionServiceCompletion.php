<?php

namespace Flageolett\eZCompletionBundle\Service;

use eZ\Publish\API\Repository\SectionService;
use eZ\Publish\API\Repository\Values\Content\Section;
use Flageolett\eZCompletionBundle\Abstracts\CompletionAbstract;
use eZ\Publish\Core\Repository\Repository;

class SectionServiceCompletion extends CompletionAbstract
{
    /** @var SectionService */
    protected $sectionService;
    /** @var Repository */
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->sectionService = $repository->getSectionService();
        $this->repository = $repository;
    }

    public function fetchSections()
    {
        return $this->repository->sudo(function()
        {
            return array_map(function(Section $section)
            {
                return array(
                    'id' => (int)$section->id,
                    'identifier' => $section->identifier
                );
            }, $this->sectionService->loadSections());
        });
    }

    protected function getDataSource()
    {
        $section = $this->fetchSections(); 
        return compact('section');
    }
}
