**Installation**
```
composer require anboo/profiler-bundle
```

**Configuration**
```yaml
anboo_profiler:
    profile_command: true
    profile_controller: true
    ignore_commands:
        - 'debug:*'
        - 'cache:clear'
    ignore_routes:
        - '\/_wdt\/*'
```

**Custom Configuration**
```yaml
anboo_profiler:
    host: '127.0.0.1'
    port: 25613
    transport_handler: Anboo\Profiler\Transport\AsyncCurlBatchTransport
    profile_command: true
    profile_controller: true
    ignore_commands:
        - 'debug:*'
        - 'cache:clear'
    ignore_routes:
        - '\/_wdt\/*'
```