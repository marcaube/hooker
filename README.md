# Hooker

Sensible git hooks for your projects.

[![Build Status](https://travis-ci.org/marcaube/hooker.svg)](https://travis-ci.org/marcaube/hooker) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/marcaube/hooker/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/marcaube/hooker/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/9cb81313-7126-49cb-8257-842cf611ab1e/mini.png)](https://insight.sensiolabs.com/projects/9cb81313-7126-49cb-8257-842cf611ab1e) [![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/marcaube/hooker?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)


## Installation

* Execute `$ composer require --dev ob/hooker=1.0.x-dev`

* Copy the hooker config `cp vendor/ob/hooker/hooker.yml.dist hooker.yml.dist` and tweak it to suit your needs

* Add the command to your project's `.git/hooks/pre-commit` hook

```bash
#!/bin/sh

./vendor/bin/hooker hook:pre-commit
```

* Finally, make it executable

```bash
$ chmod +x .git/hooks/pre-commit
```



## License

Hooker is released under the MIT License. See the bundled [LICENSE](LICENSE) file for details.
