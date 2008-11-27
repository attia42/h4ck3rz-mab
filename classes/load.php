<?php
	class Load
	{
		
		private static function __Load ($folder, $fileName, $ext=".php")
		{
			$filename = strtolower($fileName) . $ext;
			$file = site_path . $folder . DIRSEP . $filename;

			if (file_exists($file) == false) { 
				return false;
			}
		
			require_once ($file);
		}
			
		static function FromDatabases($databaseName)
		{
				self::__Load('databases',$databaseName);
		}
		
		static function FromModels($modelName)
		{
			self::__Load('models',$modelName);
		}
		
		static function FromTemplates($templateName)
		{
			self::__Load('templates',$templateName);
		}
		
		static function FromClasses($className)
		{
			self::__Load('classes',$className);
		}
		
		static function FromDatamappers($datamapName)
		{
			self::__Load('datamappers',$datamapName);
		}
			
		static function FromIncludes($includeName)
		{
			self::__Load('includes',$includeName);
		}
		
		static function FromConfig($configName)
		{
			self::__Load('config',$configName,".inc");
		}
		
	}
?>