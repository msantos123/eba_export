PGDMP              	        |            eba    16.4    16.4     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16398    eba    DATABASE     x   CREATE DATABASE eba WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Bolivia.1252';
    DROP DATABASE eba;
                postgres    false                       1259    39205    solicitudcargas    TABLE     o  CREATE TABLE export.solicitudcargas (
    id bigint NOT NULL,
    codigo character varying(255),
    planta_id bigint NOT NULL,
    usuario_id bigint NOT NULL,
    salida_inventario bigint,
    tipo character varying(255) NOT NULL,
    estado integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 #   DROP TABLE export.solicitudcargas;
       export         heap    postgres    false                       1259    39204    solicitudcargas_id_seq    SEQUENCE        CREATE SEQUENCE export.solicitudcargas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE export.solicitudcargas_id_seq;
       export          postgres    false    268            �           0    0    solicitudcargas_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE export.solicitudcargas_id_seq OWNED BY export.solicitudcargas.id;
          export          postgres    false    267            %           2604    39208    solicitudcargas id    DEFAULT     x   ALTER TABLE ONLY export.solicitudcargas ALTER COLUMN id SET DEFAULT nextval('export.solicitudcargas_id_seq'::regclass);
 A   ALTER TABLE export.solicitudcargas ALTER COLUMN id DROP DEFAULT;
       export          postgres    false    267    268    268            �          0    39205    solicitudcargas 
   TABLE DATA           �   COPY export.solicitudcargas (id, codigo, planta_id, usuario_id, salida_inventario, tipo, estado, created_at, updated_at) FROM stdin;
    export          postgres    false    268   ,       �           0    0    solicitudcargas_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('export.solicitudcargas_id_seq', 60, true);
          export          postgres    false    267            (           2606    39213 $   solicitudcargas solicitudcargas_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY export.solicitudcargas
    ADD CONSTRAINT solicitudcargas_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY export.solicitudcargas DROP CONSTRAINT solicitudcargas_pkey;
       export            postgres    false    268            �   �  x����J#Q��u�)|�8��N�����Q���sL���C��	r�\���1���v}�\�ǰ_��e,������|Yl��8��?��Ǹ����!�ј�m�-S�����\�
�Bm����ڂ���u��T�N����I�Zi�P����m4���m5f��6a�Ⱦ�}S��7�1�~�����)���[�7E��~+���7�o���F�m�S��7�o
#�F�M�o�߉�)������wE��~�:W�;��z����	��L��ߓ��N��T�KW�;�����N������ɿ�W�;���������AO�9&\ ����3(�?sL���3Ǆ��?sL���3Ǆ�@�)� � �c�@��5���-��A�����A�,�S�=��W�����S���������¿�|0��9������R@��}dJ ����T=��-E�}K���g�R�����^���g��z��_R���gjU���
� ���[�B?�~=�b?�~��P�ُ��B�d?(|B��?V:1E����	E��(������~�~X�?� ��?� ��?� �����P����^�P��c�-???� ��ꇢ�?G}K���O�~����O��W*���'�L���I�~��,���O���=��O��U���O��[m	�Oc�x����x����Ͽ��o�������V�?|v�x<�3�     