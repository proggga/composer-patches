<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
namespace Vaimo\ComposerPatches\Patch\Definition\ExploderComponents;

use Vaimo\ComposerPatches\Patch\Definition as PatchDefinition;

class SequenceVersionConfigComponent implements \Vaimo\ComposerPatches\Interfaces\DefinitionExploderComponentInterface
{
    /**
     * @var \Vaimo\ComposerPatches\Patch\Definition\Value\Analyser
     */
    private $valueAnalyser;

    /**
     * @var \Vaimo\ComposerPatches\Patch\Definition\Constraint\Exploder
     */
    private $definitionExploder;

    public function __construct()
    {
        $this->valueAnalyser = new \Vaimo\ComposerPatches\Patch\Definition\Value\Analyser();
        $this->definitionExploder = new \Vaimo\ComposerPatches\Patch\Definition\Constraint\Exploder();
    }

    public function shouldProcess($label, $data)
    {
        if (!is_array($data)) {
            return false;
        }

        return is_numeric($label)
            && isset($data[PatchDefinition::LABEL], $data[PatchDefinition::SOURCE])
            && is_array($data[PatchDefinition::SOURCE])
            && !is_array(reset($data[PatchDefinition::SOURCE]))
            && $this->valueAnalyser->isConstraint(key($data[PatchDefinition::SOURCE]));
    }

    public function explode($label, $data)
    {
        return $this->definitionExploder->process(
            $data[PatchDefinition::LABEL],
            $data[PatchDefinition::SOURCE]
        );
    }
}
