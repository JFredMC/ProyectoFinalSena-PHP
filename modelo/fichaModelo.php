<?php
	
	require_once "mainModel.php";

	class fichaModelo extends mainModel{

		/*--------- Modelo agregar FICHA ---------*/
		protected static function agregar_ficha_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblficha(FiCodigoFicha,FkRelFicha_Codigo_Programa,FiFechaInicio,FiFechaFin,FiJornada,FiHoraInicio,FiHoraFin) VALUES (:CodigoFicha,:RelFichaPrograma,:FechaInicio,:FechaFin,:Jornada,:HoraInicio,:HoraFin)");

			$sql->bindParam(":CodigoFicha",$datos['CodigoFicha']);
			$sql->bindParam(":RelFichaPrograma",$datos['RelFichaPrograma']);
			$sql->bindParam(":FechaInicio",$datos['FechaInicio']);
			$sql->bindParam(":FechaFin",$datos['FechaFin']);
			$sql->bindParam(":Jornada",$datos['Jornada']);
			$sql->bindParam(":HoraInicio",$datos['HoraInicio']);
			$sql->bindParam(":HoraFin",$datos['HoraFin']);
			$sql->execute();

			return $sql;
		}

		/*--------- Modelo eliminar FICHA ---------*/
		protected static function eliminar_ficha_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblficha WHERE FiCodigo=:Codigo");

			$sql->bindParam(":Codigo", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS EFICHA */
		protected static function datos_ficha_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblficha WHERE FiCodigo=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT FiCodigo FROM tblficha WHERE FiCodigo !='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR FICHA */
		protected static function actualizar_ficha_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblficha SET FiCodigoFicha=:CodigoFicha,FiFechaInicio=:FechaInicio,FiFechaFin=:FechaFin,FiJornada=:Jornada,FiHoraInicio=:HoraInicio,FiHoraFin=:HoraFin WHERE FiCodigo=:ID ");

			$sql->bindParam(":CodigoFicha",$datos['CodigoFicha']);
			
			$sql->bindParam(":FechaInicio",$datos['FechaInicio']);
			$sql->bindParam(":FechaFin",$datos['FechaFin']);
			$sql->bindParam(":Jornada",$datos['Jornada']);
			$sql->bindParam(":HoraInicio",$datos['HoraInicio']);
			$sql->bindParam(":HoraFin",$datos['HoraFin']);
			$sql->bindParam(":ID",$datos['ID']);
			$sql->execute();

			return $sql;			
		}

		
	}