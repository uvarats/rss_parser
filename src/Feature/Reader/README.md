# RSS Reader

Reader configuration implements pattern Chain of Responsibility. This is done for complying with Open/Closed Principle.
If you want to extend RSS Reader configuration (add caching or register some extension), then you should create new class and extend AbstractChainedConfigurator, in "configure" method you've must do needed job. In the end of method is mandatory to call "proceedToNext" (or not to call if you do not want to execute potential future configurators).
Then you must tag your new configurator in services.php with needed tag and set priority.

```php
$services->set(SomeConfigurator::class)
        ->tag(ReaderConfigurator::TAG, ['priority' => 900]);
```