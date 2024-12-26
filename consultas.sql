select * from siga._bp_planta where nombre_planta like '%COBI%'
ID	NOMBRE_PLANTA
9	RIBERALTA
10	EL SENA
25	COBIJA

select * from siga.insumo_receta where rece_nombre like '%CASTA%' -347 a 360

select skpt_planta_id, skpt_lote, skpt_rece_id,
SUM (stock_existencia_pt.skpt_cantidad) as total_cantidad,
SUM (stock_existencia_pt.skpt_planta_id) as total_planta,
count (stock_existencia_pt.skpt_lote) as total_lote
from siga.stock_existencia_pt
where skpt_planta_id in (9,10,25) and skpt_cantidad != 0
group by skpt_id,skpt_planta_id,skpt_lote,skpt_rece_id
order by skpt_planta_id desc

select skpt_rece_id, skpt_planta_id, skpt_lote,
sum(stock_existencia_pt.skpt_cantidad) as total_cantidad
from siga.stock_existencia_pt
where skpt_planta_id = 9 and skpt_rece_id = 350 and skpt_lote = '5'

select * from siga.stock_existencia_pt

select * from siga.producto_terminado_movimiento

select * from siga.producto_terminado_movimiento_detalle

where order by mvdpt_id desc

select * from export.cargas
select * from export.solicitudcargas

delete from export.solicitudcargas where id = 6

id 5 planta_id 9 usuario_id 2142

select * from siga.stock_existencia_pt 
where skpt_planta_id = 9 and skpt_rece_id = 351 and skpt_lote = '6'

select * from siga.insumo_receta
select * from siga._bp_planta

select * from siga.producto_terminado_movimiento
where mvmvpt_tipo = 'SALIDA' AND 

select * from export.detalle_salidas
select * from export.salida_detalles
select * from export.carga_detalle

select * from export.kardexes

select * from export.solicitudcargas
select * from export.cargas
select * from export.salida_detalles

TRUNCATE TABLE export.solicitudcargas
TRUNCATE TABLE export.cargas
TRUNCATE TABLE export.siga_salida_detalles

select * from siga.producto_terminado_movimiento
where mvmvpt_planta_id in (9,10,25) and mvmvpt_tipo = 'SALIDA'
and mvpt_id = 19603
order by mvmvpt_nro desc

mvdpt_mvpt_id - 19603


mvpt_id = 14433 14432 13240

select sum(mvdpt_cantidad) as total_cantidad from siga.producto_terminado_movimiento_detalle
where mvdpt_mvpt_id = 19603

select * from siga.producto_terminado_movimiento_detalle
where mvdpt_mvpt_id = 19603
where mvdpt_lote = '5'
order by mvdpt_mvpt_id desc

select * from siga.insumo_receta

select * from export.solicitudcargas
select * from export.cargas
select * from export.siga_salida_detalles
where cargaSalida_id = 20
select * from export.kardexes
select * from export.detalle_kardexes

TRUNCATE TABLE export.detalle_kardexes
delete from export.solicitudcargas where id = 6

UPDATE export.solicitudcargas	
SET estado = 1
WHERE id = 15;

select * from export.conocimientos
update export.cargas set estado = 1 where id = 2

UPDATE siga.producto_terminado_movimiento_detalle
SET mvdpt_lote = '6'
WHERE mvdpt_id = 47579;
update export.solicitudcargas set salida_inventario = null, estado = 1 where id = 11

select * from export.solicitudcargas
select * from export.cargas

select * from export.comprobante_salidas
select * from export.kardexes
select * from export.detalle_kardexes
select * from export.siga_salida_detalles
select * from export.conocimientos
select * from export.comprobante_ingresos
select * from export.comprobante_salidas
select * from export.kardexes

update export.kardexes set saldo = 150 where id = 11
update export.cargas set estado = 1 where id = 22

select * from export.cargas

TRUNCATE TABLE export.solicitudcargas
TRUNCATE TABLE export.cargas
TRUNCATE TABLE export.conocimientos
TRUNCATE TABLE export.comprobante_ingresos
TRUNCATE TABLE export.comprobante_salidas
TRUNCATE TABLE export.kardexes
TRUNCATE TABLE export.detalle_kardexes

select * from export.solicitudcargas
select * from siga.producto_terminado_movimiento where mvpt_id = 19603

select * from siga.producto_terminado_movimiento_detalle
where mvdpt_mvpt_id = 19603 and mvdpt_cantidad != 0

select * from siga._bp_planta where id_linea_trabajo = 1 and planta_estado = 'A'
id_planta 40

select * from siga.producto_terminado_movimiento_detalle where mvmvpt_planta_id = 40

select * from export.siga_salida_detalles where "cargaSalida_id"= 21

where detalle_id = 47599
order by id asc

where 'cargaSalida_id' != null

select * from export.comprobante_salidas

update export.comprobante_salidas set contenedor = 'MSNU7008770' where id = 3

select * from export.estadisticas

select contrato, sum(cantidad_caja) as total  
from export.estadisticas
group by contrato 

select zafra, sum(cantidad_caja) as total  
from export.estadisticas
group by zafra 

select contrato, sum(cantidad_caja) as total  
from export.estadisticas
group by zafra 

select * from export.poas
SELECT SUM(volumen_tn) AS total, mes 
FROM export.estadisticas 
WHERE gestion = 2024 AND mes = 'ABRIL' 
GROUP BY mes
ORDER BY mes;

update export.poas set meta_gestion = 2023 where id = 8

select * from export.liberaciones

select * from export.cargas

select * from export.detalle_kardexes
select * from export.kardexes

INSERT INTO export.kardexes (codigo_producto, articulo, proveedor_id, ubicacion, unidad, lote, saldo, costo_caja, receta_id, created_at, updated_at
) VALUES (
    'ABC123',
    'Producto Ejemplo',
    25, -- Reemplaza con el ID del proveedor correspondiente
    'Almacén Principal',
    'Cajas de 20 Kg.',
    '13',
    100,
    344.50, -- Puedes dejarlo como NULL si no hay costo
    1, -- Reemplaza con el ID de la receta correspondiente
    NOW(),
    NOW()
);

update export.poas set meta_gestion = 2023 where id = 8
update export.liberaciones set pdf_cartaliberacion = null where id = 2
update export.liberaciones set libe_estado = 0 where id = 2
select * from export.liberaciones
select * from export.comprobante_salidas
update export.comprobante_salidas set liberacion = 0

select * from export.poas

INSERT INTO export.poas (codigo_producto, articulo, proveedor_id, ubicacion, unidad, lote, saldo, costo_caja, receta_id, created_at, updated_at
) VALUES (
    'ABC123',
    'Producto Ejemplo',
    25, -- Reemplaza con el ID del proveedor correspondiente
    'Almacén Principal',
    'Cajas de 20 Kg.',
    '13',
    100,
    344.50, -- Puedes dejarlo como NULL si no hay costo
    1, -- Reemplaza con el ID de la receta correspondiente
    NOW(),
    NOW()
);

select * from export.plantas

select * from siga.producto_terminado_movimiento


SELECT 
    siga.producto_terminado_movimiento.mvpt_id,
    producto_terminado_movimiento.mvmvpt_nro,
    producto_terminado_movimiento.created_at,
    producto_terminado_movimiento.mvmvpt_tipo,
    producto_terminado_movimiento.mvmvpt_tipo_det
FROM 
    siga.producto_terminado_movimiento
WHERE 
    	siga.producto_terminado_movimiento.mvmvpt_planta_id = 9
    AND siga.producto_terminado_movimiento.mvmvpt_tipo = 'SALIDA'
    AND siga.producto_terminado_movimiento.mvmvpt_tipo_det = 'EXPORTACIÓN'
    AND siga.producto_terminado_movimiento.mvmvpt_estado = 'A'
ORDER BY 
    siga.producto_terminado_movimiento.mvmvpt_nro DESC
LIMIT 10;

select * from siga.producto_terminado_movimiento where mvpt_id = 19604
select * from 
select *, sum(mvdpt_cantidad) as total 
from siga.producto_terminado_movimiento_detalle 
where mvdpt_mvpt_id = 19604
group by 

select * from siga.producto_terminado_movimiento

select * from siga.insumo_receta where rece_nombre like '%CASTA%'
select * from siga.insumo_receta where rece_id = 347

select * from export.cargas

update export.cargas set cantidad = 135 where id = 25

select * from export.cargas
copy export.cargas FROM 'C:/Users/MANUEL/Desktop/EBA EXPORT/datos para sistema/cargas.csv' DELIMITER ';' CSV HEADER;
copy export.solicitudcargas FROM 'C:/Users/MANUEL/Desktop/EBA EXPORT/datos para sistema/solicitud_carga.csv' DELIMITER ';' CSV HEADER;
copy export.comprobante_salidas FROM 'C:/Users/MANUEL/Desktop/EBA EXPORT/datos para sistema/comprobante_salidas.csv' DELIMITER ';' CSV HEADER;
copy export.pre_facturas 
FROM 'C:/Users/MANUEL/Desktop/EBA EXPORT/datos para sistema/pre_facturas.csv' 
DELIMITER ';' CSV HEADER;

select sum(cantidad) as total from export.cargas
select * from export.solicitudcargas
select * from export.comprobante_salidas
select * from export.pre_facturas

select * from export.roles
truncate table export.roles
select * from export.model_has_roles
select * from export.model_has_permissions
select * from export.role_has_permissions
select * from export.permissions

select * from public._bp_usuarios

update export.solicitudcargas set usuario_id = 2172 where id = 68
select * from export.solicitudcargas where tipo = 'INGRESO'
delete from export.solicitudcargas where tipo = 'INGRESO'
select * from export.solicitudcargas

select * from siga.producto_terminado_movimiento where mvmvpt_planta_id = 9 AND mvmvpt_tipo = 'SALIDA' order by mvpt_id desc
select * from siga._bp_planta where nombre_planta like '%RIBERALTA%'

select * from export.siga_salida_detalles order by id desc

select * from siga.producto_terminado_movimiento_detalle where mvdpt_mvpt_id = 19602