<?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="selected_empleados[]" value="<?php echo $empleado['id_empleado']; ?>" class="empleado-checkbox">
                    </td>
                    <td><?php echo $empleado['nombre']; ?></td>
                    <td><?php echo $empleado['apellido1']; ?></td>
                    <td><?php echo $empleado['apellido2']; ?></td>
                    <td><?php echo $empleado['direccion']; ?></td>
                    <td><?php echo $empleado['localidad']; ?></td>
                    <td><?php echo $empleado['telefono']; ?></td>
                    <td><?php echo $empleado['titulo']; ?></td>
                    <td><?php echo $empleado['teletrabajo'] ? 'Sí' : 'No'; ?></td>
                    <td>
                    <a href="exportar_empleado.php?id=<?php echo $empleado['id_empleado']; ?>" class="btn btn-danger ml-2"><i class="fas fa-file-pdf"></i></a>
                        <a href="empleado.php?id=<?php echo $empleado['id_empleado']; ?>&page=<?php echo $page; ?>&limit=<?php echo $limit; ?>" class="btn btn-primary">Ver</a>
                        
                    </td>
                </tr>
            <?php endforeach; ?>