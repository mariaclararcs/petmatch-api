<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Prompts\MultiSelectPrompt;
use Laravel\Prompts\TextPrompt;

class ApiCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CRUD API';

    protected $type = 'Model';

    protected $name = '';

    protected $lowerName = '';

    protected $routepath = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prompt = new TextPrompt('Por favor, insira o nome da classe principal:');
        $this->name = $prompt->prompt();
        $this->routepath = Str::plural(Str::snake($this->name, '-'));
        $this->lowerName = Str::lower($this->name);

        $options = [
            'controller' => 'Criar Controller',
            'service' => 'Criar Service',
            'factory' => 'Criar Factory',
            'seeder' => 'Criar Seeder',
            'resource' => 'Criar Resource',
            'test' => 'Criar Teste Pest',
            'migration' => 'Criar Migration',
            'routes' => 'Criar Routes',
            'model' => 'Criar Model',
            'all' => 'Criar todos os componentes',
        ];

        $selectedOptions = [];

        $multiSelect = new MultiSelectPrompt(
            'Selecione os componentes que deseja criar:',
            $options,
            [$options['model']]
        );

        $selectedOptions = $multiSelect->prompt();

        if (in_array('all', $selectedOptions)) {
            $this->generateService();
            $this->generateRequests();
            $this->generateController();
            $this->generateMigration();
            $this->generateRoutes();
            $this->generateTests();
            $this->generateFactory();
            $this->generateSeeder();
            $this->generateResource();
            $this->generateModel();

            return;
        }

        if (in_array('controller', $selectedOptions)) {
            $this->generateController();
        }

        if (in_array('resource', $selectedOptions)) {
            $this->generateResource();
        }

        if (in_array('service', $selectedOptions)) {
            $this->generateService();
        }

        if (in_array('factory', $selectedOptions)) {
            $this->generateFactory();
        }

        if (in_array('model', $selectedOptions)) {
            $this->generateModel();
        }
    }

    protected function createDirectoryIfNotExists(string $path): void
    {
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    protected function createdFileIfNotExists(string $path, string $content, string $context): void
    {
        if (File::exists($path)) {
            $message = sprintf("$context [%s] already exists.", $path);
            $this->components->error(string: $message);

            return;
        }

        File::put($path, $content);
        $message = sprintf("$context [%s] created successfully.", $path);
        $this->components->info($message);
    }

    protected function generateResource(): void
    {
        $this->call('make:resource', [
            'name' => "$this->name".'/'."$this->name".'Resource',
        ]);
    }

    protected function generateModel(): void
    {
        $filePath = app_path("Models/{$this->name}.php");

        $this->createDirectoryIfNotExists(app_path('Models'));

        $this->createdFileIfNotExists($filePath, $this->getModelContent(), 'Model');
    }

    protected function generateService(): void
    {
        $filePath = app_path("Services/$this->name/{$this->name}Service.php");

        $this->createDirectoryIfNotExists(app_path('Services'));
        $this->createDirectoryIfNotExists(app_path("Services/$this->name"));

        $this->createdFileIfNotExists($filePath, $this->getServiceContent(), 'Service');
    }

    protected function generateRequests(): void
    {
        $requests = [
            'DestroyRequest',
            'IndexRequest',
            'ShowRequest',
            'StoreRequest',
            'UpdateRequest',
        ];

        $filePath = app_path("Http/Requests/$this->name");

        $this->createDirectoryIfNotExists($filePath);

        foreach ($requests as $request) {
            $requestFilePath = app_path("Http/Requests/$this->name/{$request}.php");
            $this->createdFileIfNotExists($requestFilePath, $this->getRequestContent($request), 'Request');
        }
    }

    protected function generateController(): void
    {
        $filePath = app_path("Http/Controllers/{$this->name}/{$this->name}Controller.php");

        $this->createDirectoryIfNotExists(app_path('Http/Controllers'));

        $this->createDirectoryIfNotExists(app_path("Http/Controllers/$this->name"));

        $this->createdFileIfNotExists($filePath, $this->getControllerContent(), 'Controller');
    }

    protected function generateMigration(): void
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->name)));

        $tableName = Carbon::now()->format('Y_m_d_His')."_create_{$table}_table";

        $filePath = base_path("database/migrations/{$tableName}.php");

        $this->createDirectoryIfNotExists('database/migrations');

        $this->createdFileIfNotExists($filePath, $this->getMigrationContent($table), 'Migration');
    }

    protected function generateRoutes(): void
    {
        $lowerName = Str::snake($this->name);

        $filePath = base_path("routes/api/{$lowerName}.php");

        $this->createDirectoryIfNotExists('routes/api');

        $this->createdFileIfNotExists($filePath, $this->getRoutesContent(), 'Route');

        $filePath = base_path('routes/api/index.php');

        $fileContent = file_get_contents($filePath);

        $newLine = "\nrequire base_path('/routes/api/{$this->lowerName}.php');\n";

        $fileContent .= $newLine;

        file_put_contents($filePath, $fileContent);
    }

    protected function generateTests(): void
    {
        $filePath = base_path("tests/Feature/{$this->name}Test.php");

        $this->createDirectoryIfNotExists('tests/Feature');

        $this->createdFileIfNotExists($filePath, $this->getTestsContent(), 'Test');
    }

    protected function generateFactory(): void
    {
        $factory = Str::studly($this->name);

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->name,
        ]);
    }

    protected function generateSeeder(): void
    {
        $seeder = Str::studly(class_basename($this->name));

        $this->call('make:seeder', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    protected function getModelContent(): string
    {
        return "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {$this->name} extends Model
{
    /** @use HasFactory<\Database\Factories\\{$this->name}Factory> */
    use HasFactory;

    use SoftDeletes;
    use HasUuids;

}";
    }

    protected function getServiceContent(): string
    {
        return "<?php

namespace App\Services\\{$this->name};

use App\Models\\{$this->name};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class {$this->name}Service
{

    /**
     * @param  array{
     *     search: string,
     *     page: string,
     *     per_page: string,
     * }  \$data
     * @return LengthAwarePaginator<{$this->name}>
     */
    public function index(array \$data): LengthAwarePaginator
    {
        return {$this->name}::query()->when(\$data['search'], fn (Builder \$query)  =>
            \$query->where('id', 'like', '%\$search%')
        )->paginate(perPage: (int) \$data['per_page'], page: (int) \$data['page']);
    }

    /**
    * @param array<string,mixed> \$data
    */
    public function store(array \$data): {$this->name}
    {
        return {$this->name}::query()->create(\$data);
    }

    /**
    * @param array{id:string} \$data
    */
    public function destroy(array \$data): ?bool
    {
        return {$this->name}::query()->findOrFail(\$data['id'])->delete();
    }

    /**
    * @param array{id:string} \$data
    */
    public function show(array \$data): ?{$this->name}
    {
        return {$this->name}::query()->findOrFail(\$data['id']);
    }

    /**
    * @param array{id:string} \$data
    */
    public function update(array \$data): bool
    {
        return {$this->name}::query()->findOrFail(\$data['id'])->update(\$data);
    }
}";
    }

    protected function getRequestContent(string $request): string
    {

        if ($request === 'IndexRequest') {
            return "<?php

namespace App\Http\Requests\\{$this->name};

use Illuminate\Foundation\Http\FormRequest;

class {$request} extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable','string'],
            'per_page' => ['nullable','string'],
            'page' => ['nullable','string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'search' => 'Pesquisa',
            'per_page' => 'Por página',
            'page' => 'Página',
        ];
    }

    public function prepareForValidation(): void
    {
        \$this->merge([
            'page' => \$this->query('page', null),
            'per_page' => \$this->query('per_page', null),
            'search' => \$this->query('search', null),
        ]);
    }
}";
        }

        return "<?php

namespace App\Http\Requests\\{$this->name};

use Illuminate\Foundation\Http\FormRequest;

class {$request} extends FormRequest
{
    public function rules(): array
    {
        return [
            // Logic here
        ];
    }

    public function attributes(): array
    {
        return [
            // Logic here
        ];
    }

    public function prepareForValidation(): void
    {
        \$this->merge([
            // Logic here
        ]);
    }
}";
    }

    protected function getControllerContent(): string
    {
        return "<?php

namespace App\Http\Controllers\\{$this->name};

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\\{$this->name}\IndexRequest;
use App\Http\Requests\\{$this->name}\StoreRequest;
use App\Http\Requests\\{$this->name}\UpdateRequest;
use App\Http\Resources\\{$this->name}\\{$this->name}Resource;
use App\Models\\{$this->name};
use App\Services\\{$this->name}\\{$this->name}Service;
use Illuminate\Http\JsonResponse;

class {$this->name}Controller extends Controller
{

    public function __construct(public {$this->name}Service \$service) {}


    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest \$request): JsonResponse
    {
        try {

            return ReturnApi::success(
            {$this->name}Resource::collection($this->name::all()),
            '{$this->name} successfully listed!'
            );
        } catch (ApiException \$e) {
            throw new ApiException(\$e->getMessage(), \$e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest \$request): JsonResponse
    {
        try {
            return ReturnApi::success(
                \$this->service->store(
                    \$request->validated(),
                ),
            '{$this->name} successfully created!',
            201
            );
        } catch (ApiException \$e) {
            throw new ApiException(\$e->getMessage(), \$e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($this->name $$this->lowerName): JsonResponse
    {
        try {
            return ReturnApi::success(
                {$this->name}Resource::make($$this->lowerName),
                '{$this->name} successfully consulted!'
            );
        } catch (ApiException \$e) {
            throw new ApiException(\$e->getMessage(), \$e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest \$request,$this->name $$this->lowerName): JsonResponse
    {
        try {
            return ReturnApi::success(
                $$this->lowerName->update(\$request->validated()),
                '{$this->name} successfully updated!'
            );
        } catch (ApiException \$e) {
            throw new ApiException(\$e->getMessage(), \$e->getCode());
        }
    }

    /**
    * Destroy the specified resource in storage.
    */
    public function destroy($this->name $$this->lowerName): JsonResponse
    {

        try {
            $$this->lowerName->delete();

            return ReturnApi::success(
                message: '{$this->name} successfully deleted!'
            );
        } catch (ApiException \$e) {
            throw new ApiException(\$e->getMessage(), \$e->getCode());
        }
    }
}";
    }

    protected function getRoutesContent(): string
    {
        return "<?php

use App\Http\Controllers\\{$this->name}\\{$this->name}Controller;
use Illuminate\Support\Facades\Route;

Route::apiResource('$this->routepath',{$this->name}Controller::class);
    ";
    }

    protected function getTestsContent(): string
    {
        return "<?php

namespace Tests\Feature;

use App\Models\\{$this->name};

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

describe('{$this->name} routes', function () {
    it('[GET] {$this->routepath}', function () {
        {$this->name}::factory()->create();

        \$response = get('/api/{$this->routepath}')
            ->assertOk()
            ->json();

            expect(\$response['data']['data'])->toHaveCount(1);
    });

    it('[GET] {$this->routepath}/{id}', function () {
        \${$this->lowerName} = {$this->name}::factory()->create();

        \$response = get(\"api/{$this->routepath}/\${$this->lowerName}->id\")
            ->assertOk()
            ->json();

            expect(\$response['data']['id'])->toBeString()->toBeUuid();
    });

    it('[POST] {$this->name}', function () {
        \$body = {$this->name}::factory()->make()->toArray();

        post('api/{$this->routepath}', \$body)
            ->assertCreated()
            ->json();

            \${$this->lowerName}OnDatabase = {$this->name}::query()->first();

            expect(\${$this->lowerName}OnDatabase->id)->toBeString()->toBeUuid();
    });

    it('[DELETE] {$this->routepath}/{id}', function () {
        \${$this->lowerName} = {$this->name}::factory()->create();

        delete(\"api/{$this->routepath}/\${$this->lowerName}->id\")
            ->assertOk()
            ->json();

            \${$this->lowerName}OnDatabase = {$this->name}::query()->find(\${$this->lowerName}->id);

            expect(\${$this->lowerName}OnDatabase)->toBeNull();
    });

    it('[PUT] {$this->routepath}/{id}', function () {
        \${$this->lowerName} = {$this->name}::factory()->create();
        \$body = {$this->name}::factory()->make()->toArray();

        put(\"api/{$this->routepath}/\${$this->lowerName}->id\",
            \$body)
            ->assertOk()
            ->json();
    });
});";
    }

    protected function getMigrationContent(string $table): string
    {
        return "<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->uuid('id')->primary();
            \$table->timestamps();
            \$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};";
    }
}
