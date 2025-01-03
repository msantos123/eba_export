PGDMP  6            	        |            eba    16.4    16.4     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16398    eba    DATABASE     x   CREATE DATABASE eba WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Bolivia.1252';
    DROP DATABASE eba;
                postgres    false                        1259    72379    comprobante_salidas    TABLE     #  CREATE TABLE export.comprobante_salidas (
    id bigint NOT NULL,
    fecha_salida date NOT NULL,
    empresa character varying(100) NOT NULL,
    responsable character varying(100) NOT NULL,
    camion character varying(50) NOT NULL,
    placa character varying(10) NOT NULL,
    licencia character varying(10) NOT NULL,
    celular integer NOT NULL,
    contenedor character varying(20) NOT NULL,
    presinto character varying(20) NOT NULL,
    reserva character varying(20) NOT NULL,
    factura integer NOT NULL,
    destino character varying(100) NOT NULL,
    codigo_salida character varying(20) NOT NULL,
    pdf_comprobante_salida character varying(100),
    liberacion integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 '   DROP TABLE export.comprobante_salidas;
       export         heap    postgres    false                       1259    72378    comprobante_salidas_id_seq    SEQUENCE     �   CREATE SEQUENCE export.comprobante_salidas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE export.comprobante_salidas_id_seq;
       export          postgres    false    288            �           0    0    comprobante_salidas_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE export.comprobante_salidas_id_seq OWNED BY export.comprobante_salidas.id;
          export          postgres    false    287            %           2604    72382    comprobante_salidas id    DEFAULT     �   ALTER TABLE ONLY export.comprobante_salidas ALTER COLUMN id SET DEFAULT nextval('export.comprobante_salidas_id_seq'::regclass);
 E   ALTER TABLE export.comprobante_salidas ALTER COLUMN id DROP DEFAULT;
       export          postgres    false    288    287    288            �          0    72379    comprobante_salidas 
   TABLE DATA           �   COPY export.comprobante_salidas (id, fecha_salida, empresa, responsable, camion, placa, licencia, celular, contenedor, presinto, reserva, factura, destino, codigo_salida, pdf_comprobante_salida, liberacion, created_at, updated_at) FROM stdin;
    export          postgres    false    288   �       �           0    0    comprobante_salidas_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('export.comprobante_salidas_id_seq', 5, true);
          export          postgres    false    287            (           2606    72387 ,   comprobante_salidas comprobante_salidas_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY export.comprobante_salidas
    ADD CONSTRAINT comprobante_salidas_pkey PRIMARY KEY (id);
 V   ALTER TABLE ONLY export.comprobante_salidas DROP CONSTRAINT comprobante_salidas_pkey;
       export            postgres    false    288            �     x���In�0E��)|��Y��؀7��M�en��a�)RF��������UO�)I���rH}���<���7}���oo�:w)�K�k�>>@ćď��)=��^{�D����z��@qCy֥% JJ(+(PZPC��5�(k(ϪƂ�T�P�5� ����AQ����AW�ЦB�dڰ�(�i����� sP1�C�Tc��F�A\i�^���ry���r#!i��C�{ � �h� �P�Q�n�x� �P�X��UDL�Gh�,��3��,Bce��/��������q�1`NAZ�aj4O_�w��07���R:�{�4���t4�`�,�=D�o�:��p�@���Snjז��f@ �W������� ��r�� ��r胧�_����[Χ���%��C���F��x�/�Q�ƍ� �-w�'�H�>����Ηy}�G�0RbHmQ&�҂�{
��wi �ͳs}K3a�f�=���r=��.%фqC�y��qh°���c�-�M j�����V��h���ʞ�F�Q�<B�G��4��Vr���z�_�߳L�'uy>'k�W��6�g�ɉd���#�o����4���G�	���6mh�&��U2�P	�mm����\BS���%��S������&L�خ�TRw��0�չ���OF�	K%��~"FamktMy[� |�d�-ބY}�V�]� F���������N�A��~!�`O�R���_깤 n����Ku� nj4שw�����t�חsf~��/��/"u��[D�u����uY�?^����%F��Z
`��F��H��G����,3� ����|gl�`C ��{c�VO*�J�;D������>��P�-�[t7�(�f �n��Ǐ�bɷ�p�Y�
�E�bQk���X��1^]��G-RQ@*BZOTЊ��U+
hE�Z��ot�bA�Xy�b�T,(+�\��buP1�'�iӥ.��K�D <bA��n@1�%t��b�>��O��� �X�'V}bq��������     