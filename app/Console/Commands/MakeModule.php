<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Signature('make:module {name}')]
#[Description('Scaffold a full module: model, migration, controller, factory, repository, interface, and a basic view.')]
class MakeModule extends Command
{
    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $lower = Str::camel($name);
        $plural = Str::plural($lower);
        $table = Str::snake(Str::plural($name));

        $this->info("Scaffolding module: {$name}");

        $this->makeModel($name);
        $this->makeMigration($name, $table);
        $this->makeFactory($name);
        $this->makeRepositoryInterface($name);
        $this->makeRepository($name);
        $this->makeController($name);
        $this->makeView($plural);

        $this->info("Module {$name} scaffolded successfully!");
        $this->warn('Remember to: bind the repository in AppServiceProvider, add routes, and run migrations.');
    }

    protected function makeModel(string $name): void
    {
        $this->call('make:model', [
            'name' => $name,
        ]);
    }

    protected function makeMigration(string $name, string $table): void
    {
        $timestamp = date('Y_m_d_His');
        $path = database_path("migrations/{$timestamp}_create_{$table}_table.php");

        $stub = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;

        File::put($path, $stub);
        $this->line("Created Migration: {$path}");
    }

    protected function makeFactory(string $name): void
    {
        $path = database_path("factories/{$name}Factory.php");
        if (File::exists($path)) {
            $this->warn('Factory already exists, skipping.');

            return;
        }

        $stub = <<<PHP
<?php

namespace Database\Factories;

use App\Models\\{$name};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<{$name}>
 */
class {$name}Factory extends Factory
{
    public function definition(): array
    {
        return [
            //
        ];
    }
}
PHP;

        File::put($path, $stub);
        $this->line("Created Factory: {$path}");
    }

    protected function makeRepositoryInterface(string $name): void
    {
        File::ensureDirectoryExists(app_path('Repositories/Contracts'));
        $path = app_path("Repositories/Contracts/{$name}RepositoryInterface.php");

        if (File::exists($path)) {
            $this->warn('Interface already exists, skipping.');

            return;
        }

        $stub = <<<PHP
<?php

namespace App\Repositories\Contracts;

use App\Models\\{$name};
use Illuminate\Database\Eloquent\Collection;

interface {$name}RepositoryInterface
{
    public function all(): Collection;
    public function create(array \$data): {$name};
    public function update({$name} \${$this->camel($name)}, array \$data): {$name};
    public function delete({$name} \${$this->camel($name)}): void;
}
PHP;

        File::put($path, $stub);
        $this->line("Created Interface: {$path}");
    }

    protected function makeRepository(string $name): void
    {
        File::ensureDirectoryExists(app_path('Repositories'));
        $path = app_path("Repositories/{$name}Repository.php");
        $var = $this->camel($name);

        if (File::exists($path)) {
            $this->warn('Repository already exists, skipping.');

            return;
        }

        $stub = <<<PHP
<?php

namespace App\Repositories;

use App\Models\\{$name};
use App\Repositories\Contracts\\{$name}RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class {$name}Repository implements {$name}RepositoryInterface
{
    public function all(): Collection
    {
        return {$name}::all();
    }

    public function create(array \$data): {$name}
    {
        return {$name}::create(\$data);
    }

    public function update({$name} \${$var}, array \$data): {$name}
    {
        \${$var}->update(\$data);
        return \${$var};
    }

    public function delete({$name} \${$var}): void
    {
        \${$var}->delete();
    }
}
PHP;

        File::put($path, $stub);
        $this->line("Created Repository: {$path}");
    }

    protected function makeController(string $name): void
    {
        $path = app_path("Http/Controllers/{$name}Controller.php");
        $var = $this->camel($name);
        $view = Str::plural(Str::snake($name));

        if (File::exists($path)) {
            $this->warn('Controller already exists,skipping.');

            return;
        }

        $stub = <<<PHP
<?php

namespace App\Http\Controllers;

use App\Models\\{$name};
use App\Repositories\Contracts\\{$name}RepositoryInterface;
use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    protected {$name}RepositoryInterface \${$view};

    public function __construct({$name}RepositoryInterface \${$view})
    {
        \$this->{$view} = \${$view};
    }

    public function index()
    {
        \${$view} = \$this->{$view}->all();
        return view('{$view}.index', ['{$view}' => \${$view}]);
    }

    public function store(Request \$request)
    {
        \$validated = \$request->validate([
            //
        ]);

        \$this->{$view}->create(\$validated);
        return redirect('/{$view}');
    }

    public function update(Request \$request, {$name} \${$var})
    {
        \$validated = \$request->validate([
            //
        ]);

        \$this->{$view}->update(\${$var}, \$validated);
        return redirect('/{$view}');
    }

    public function destroy({$name} \${$var})
    {
        \$this->{$view}->delete(\${$var});
        return redirect('/{$view}');
    }
}
PHP;

        File::put($path, $stub);
        $this->line("Created Controller: {$path}");
    }

    protected function makeView(string $plural): void
    {
        $dir = resource_path("views/{$plural}");
        File::ensureDirectoryExists($dir);
        $path = "{$dir}/index.blade.php";

        if (File::exists($path)) {
            $this->warn('View already exists, skipping.');

            return;
        }
        $stub = <<<BLADE
<x-layouts::app :title="'{$plural}'">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{$plural}</h1>
        {{-- TODO: build out list/form UI --}}
    </div>
</x-layouts::app>
BLADE;

        File::put($path, $stub);
        $this->line("Created View: {$path}");
    }

    protected function camel(string $name): string
    {
        return Str::camel($name);
    }
}
