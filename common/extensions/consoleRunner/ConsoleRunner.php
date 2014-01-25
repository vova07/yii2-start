<?php
namespace common\extensions\consoleRunner;

use Yii;
use yii\base\Component;

/**
 * Класс для запуска консольных команд в фоновом режиме.
 * 
 * Пример использования:
 * ```
 * ...
 * $cr = new ConsoleRunner;
 * $cr->run('users/signup param1 param2 ...');
 * ...
 * ```
 */
class ConsoleRunner extends Component
{
    /**
     * @var string Данная переменная хранит путь к индекс файлу консоли оносительно крневой папки приложения @root.
     */
    protected $_consoleFile;
    
    /**
     * @inheritdoc
     */
    public function init($consoleFile = 'yii')
    {
        $this->_consoleFile = $consoleFile;
    }
    
    /**
     * Запускает консольную команду в фоновом режиме.
     * @param string $cmd Конаольная команда которая должна выполнятся в фоновом режиме.
     * @return boolean
     */
    public function run($cmd)
    {
        $cmd = Yii::getAlias('@root') . DIRECTORY_SEPARATOR . $this->_consoleFile . ' ' . $cmd;
        if ($this->isWindows()) {
            pclose(popen('start /b ' . $cmd, 'r'));
        } else {
            pclose(popen($cmd . ' /dev/null &', 'r'));
        }
        return true;
    }
    
    /**
     * Функция для проверки операционной системы.
     */
    protected function isWindows()
    {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
            return true;
        } else {
            return false;
        }
    }
}