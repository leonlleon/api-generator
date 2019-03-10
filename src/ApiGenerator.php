<?php
namespace SoliDry;

use SoliDry\Controllers\BaseCommand;

class ApiGenerator extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate {inputFile? : The file (in yaml format) based on which code-base will be generated.} 
    {--migrations : Whether to generate migrations for RDBMS} 
    {--regenerate : Whether to regenerate code by overriding previously created files} 
    {--merge= : Type of merge: "last" to merge last generated changes with current document, "number" of steps to get back in history e.g.: --merge=9 will get code-generator 9 steps backward to merge, "timestamp" generator gets to the concrete files by time in history}
    {--rollback= : Rollbacks the state to "last" or "number" as described in merge command, without preserving any further changes. With this option there is no need to define inputFile} 
    {--no-history : Set this option if you don`t want to save history} 
    {--tests : To generate functional/integration tests for current API}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PHP-code generator (based on OAS) for Laravel framework, with complete support of JSON-API data format 
    -------------------------------------------
    By passing an input file to api:generate command you can easily generate code-base for a project, 
    whether it will be monolithic one, or some sort of micro-services, light inner APIs, SPAs etc
    See more on https://github.com/RJAPI/api-generator';

    /**
     *  Laravel handler for console commands
     */
    public function handle()
    {
        try {
            $inputFiles = $this->argument('inputFile') ?? $this->getRollbackInputFile();
            $this->actionIndex($inputFiles);
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}