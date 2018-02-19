<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
    <link rel="stylesheet" type="text/css" href="../../../../../lib/jeasyui1.4/themes/metro-blue/easyui.css">
    <link rel="stylesheet" type="text/css" href="../../../../../lib/jeasyui1.4/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../../../../../lib/jeasyui1.4/themes/color.css">
    <link rel="stylesheet" type="text/css" href="../../../../../lib/jeasyui1.4/demo/demo.css">
    <script type="text/javascript" src="../../../../../lib/jeasyui1.4/jquery.min.js"></script>
	
    <script type="text/javascript" src="../../../../../lib/jeasyui1.4/jquery.easyui.min.js"></script>
	
	<script type="text/javascript" src="../../../../../lib/jeasyui1.4/locale/easyui-lang-es.js"></script>
	
	
</head>
<body>
    <h2>Mantenedor Prestadores</h2>
    
    
    <table id="dg" title="Listado Porfesionales" class="easyui-datagrid tablesorter" style="width:750px;height:450px"
            url="get_users.php"
            toolbar="#toolbar" 
            fitColumns="true" singleSelect="true"
           	rownumbers="true" pagination="true">
			
        <thead>
            <tr>
				<th field="id" width="40" sortable="true" >Id</th>
				<th field="activo" width="25" sortable="true" >Activo</th>
				<th field="rut" width="55" sortable="true" >Rut</th>
                <th field="nombres" width="100" sortable="true" >Nombres</th>
                <th field="apellidoPaterno" sortable="true" width="80" >Apellido Paterno</th>
                <th field="telefono" width="60">Telefono</th>
                <th field="nombre_especialidad" sortable="true" width="50" >Especialidad</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Usurio</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar User</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px;height:480px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">Datos Profesional</div>
        <form id="fm" method="post" novalidate>
            <div class="fitem">
                <label>Activo:</label>
                <select id="activo" class="easyui-combobox" name="activo" style="width:70px;" required="true" >
				<option value="">Seleccione</option>
					<option>si</option>
					<option>no</option>
    			</select>
				
            </div>
			<div class="fitem">
                <label>Rut:</label>
                <input name="rut" class="easyui-textbox" required="true">
            </div>
			<div class="fitem">
                <label>Nombres:</label>
                <input name="nombres" type="text"   required="true">
            </div>
            <div class="fitem">
                <label>Apellido Paterno:</label>
                <input name="apellidoPaterno" class="easyui-textbox" required="true">
            </div>
			<div class="fitem">
                <label>Apellido Materno:</label>
                <input name="apellidoMaterno" class="easyui-textbox" required="true">
            </div>
            <div class="fitem">
                <label>Telefono:</label>
                <input type = "text" pattern="[0-9]*" name="telefono" >
            </div>
			<div class="fitem">
                <label>Celular:</label>
                <input type = "text" pattern="[0-9]*" name="celular" >
            </div>
			
            <div class="fitem">
                <label>Especialidad:</label>
               	<input class="easyui-combobox" 
            name="especialidad"
            data-options="
                    url:'get_especialidad.php',
                    method:'get',
                    valueField:'id',
                    textField:'especialidad',
                    panelHeight:'auto'
            ">
				
            </div>
			<div class="fitem">
                <label>Cobro Santiago:</label>
                <input type = "text" pattern="[0-9]*" name="cobroSantiago" >
            </div>
			<div class="fitem">
                <label>Cobro Region:</label>
                <input type = "text" pattern="[0-9]*" name="cobroRegiones" >
            </div>
				                
                    <input type="hidden" name="id">
                
                    
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>


    <script type="text/javascript">
	       var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('setTitle','Nuevo Profesional');
            $('#fm').form('clear');
            url = 'save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Editar Profesional');
                $('#fm').form('load',row);
                url = 'update_user.php?id='+row.id;
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirma','Esta seguro que desea Eliminar este usuario..?',function(r){
                    if (r){
                        $.post('remove_user.php',{id:row.id},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
		
		
		
    </script>
    <style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
        .fitem input{
            width:160px;
        }
    </style>
</body>
</html>