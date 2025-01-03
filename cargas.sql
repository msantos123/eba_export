PGDMP              	        |            eba    16.4    16.4     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16398    eba    DATABASE     x   CREATE DATABASE eba WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Bolivia.1252';
    DROP DATABASE eba;
                postgres    false            (           1259    80585    cargas    TABLE     �  CREATE TABLE export.cargas (
    id bigint NOT NULL,
    codigo_producto character varying(255) NOT NULL,
    nombre_producto character varying(255) NOT NULL,
    descripcion character varying(255) NOT NULL,
    calidad character varying(255),
    lote character varying(20) NOT NULL,
    cantidad integer NOT NULL,
    costo_caja double precision,
    kilosnetos double precision NOT NULL,
    librasnetas double precision NOT NULL,
    precio_kilo double precision,
    precio_libra double precision,
    receta_id bigint NOT NULL,
    solicitud_cargas bigint NOT NULL,
    kardex_id bigint,
    estado integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE export.cargas;
       export         heap    postgres    false            '           1259    80584    cargas_id_seq    SEQUENCE     v   CREATE SEQUENCE export.cargas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE export.cargas_id_seq;
       export          postgres    false    296            �           0    0    cargas_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE export.cargas_id_seq OWNED BY export.cargas.id;
          export          postgres    false    295            %           2604    80588 	   cargas id    DEFAULT     f   ALTER TABLE ONLY export.cargas ALTER COLUMN id SET DEFAULT nextval('export.cargas_id_seq'::regclass);
 8   ALTER TABLE export.cargas ALTER COLUMN id DROP DEFAULT;
       export          postgres    false    295    296    296            �          0    80585    cargas 
   TABLE DATA           �   COPY export.cargas (id, codigo_producto, nombre_producto, descripcion, calidad, lote, cantidad, costo_caja, kilosnetos, librasnetas, precio_kilo, precio_libra, receta_id, solicitud_cargas, kardex_id, estado, created_at, updated_at) FROM stdin;
    export          postgres    false    296   G       �           0    0    cargas_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('export.cargas_id_seq', 1, true);
          export          postgres    false    295            (           2606    80593    cargas cargas_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY export.cargas
    ADD CONSTRAINT cargas_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY export.cargas DROP CONSTRAINT cargas_pkey;
       export            postgres    false    296            �   �  x����n��׭��2Y耗"��F�L��H�dፁ�M��"�<H�)/�d���f�6d�6�>�R�*j!��|�{���N�����O������O��?���ۇ秿?>=|x~��qz���/���������������t�����w�Bȉ��~~��������d&uZ3i�'�����Pt'՝P�R���\���?��\p~x��㧃8]���珿�y�?=�����FR��Ws֣꼜���a�Y`��)E�TJ�s�N�.�j[N��4XL1U¤����b)�sƞʹ�2_�It}25��a)Ӗ�|�"����9��RA�y4&q1qZ(b�F���k��M�p)5�ҵ�#6&X-����4G��M�p4-�b1V�s��a5���K�SB����r���nZKǤT8�H�z(%v-�*%J��\��8�(������8(B�=H�IX�u�w����S9��DW;.�ι�9@s�6� �8�'�����C�Ͼ�+��AIn�C##pQ5Ht>%2�O���q=�
��8 J��Q-��sz�� \3ӃE�m6�i�މ��J��S�嚟�B�z(�a7��%����%�r�Ez�T]�QP��)�t4�Pn��p:�Xѵ{4
�s"���F9�8)��<'eLn̈�8Y�Lc���ƮQbpy1W�@R��"l._��;��	VH�Y!�Iq
)*�zL�k@_T<7G�\P��4`�h=�)C|���΍�lγ��0'3#7pdp
h?��	����W�+�f�)����o7$N��F\������Q>���2}��d#6��%!�т��;`�-6���q�b�!��7����ݢ��ڬ��Y��	��� '��b�čkYl՛�Uw��x"�K	Tƌ����[=`p~6ٜت��;č�غ�|8W}�APl�[>��DPӻ��|UD��.����><��z��VPH���kQ���<��U]-c3_�6��3=|شOӽ	r�k�q��N���<�9��������y��KBn�jƖx�mS�w!b��K���lF��	�*|�\	\	/-F���Xd#â#�tu���?��vWJ}�W�Ӣ��2��UL$��݈�0��r	Ψ9yoO���څ�s��%����`�I������K��>O�(n��ak�*Rf[��V�gc����r��yi9dBf'�lVwU
J��h�A24�W��A:�����fz���n�Y�: 曛��q����3�EE���҃��������ae��l:�V҃M��Jz��Pf*	ug�7��A!�t�9��$5Ά-Q���Oa��隀my�P���z0qA�Y���&3I���VL׃����@�E���
�-&3&I
�ة��ą.
i$]9�9(IW[Φ�ej�{��FvQbS�/�E����p0���H��g��&`s^y˯m�1Jp��j:�lJ\���m�-�1J��i��lJl5���y����r��1^I%�;k1"�Ҹr�B`ڔ���*WspL1�ڧz�_�: �5��cXmf�Y�E�, �X����+v���TO�Vv��z0����0���b~�����O�&��lFNm�>-v���܄fbf�����A�(1�,�u�ܒ�%�U\prsew`-%M6!��W���J�ez��RD��׏�Ս�M�l�+�K;���k��"�w���9%J���V9 ��%�BQ�v��.��?�E�Dq#e�8L
������R���������P�s�������d��T�����p&�)/]����((�R5;�:
q7�X�!W6�
n����ήQ�ߡ������1ŝ�~P<��)�O��Z���4d���n���t���"�Ӄ.�X>%��N�"(���zO�8&x�ռ6�v�hrå��:wg��W~��R��p��*
�Y��dC��I.S�&&�*:�0��@Δ�^����qʢ�n�2N�L=*uvR(k]�F�J iTŉT.)��(]�K�I��J��?����=��2��_�� �N��ߺx�� q�!P�i����FL�)�))\-�5�I��b�&���Z͚�i� ��6{Rlܧ�|w�p�?n�7e����6gP�ܨ��5g�͉֓�Xر��br{v	����m�^Lp���I�b�Fa�z��n����xژ�oO.{�{L��J���Z<`E*�Ⱥ��� �H=Q+� ��*��Z�=P�ڤXՖ��uDgd9Y��G���2k�H��,,c�ÊL�z`�L�v:�C��Z� R�<�miu�uK2�RܩU�m�m)�)~M�V��2M6�Sl��_
@nу�)�/�(�sW�5m�lRd־0,L ���/	5O�h1+جh?�6��v�j�x T�bi3,]+����\^Pn�g��b*c7�)�s?��R�HlM��RvP�h8y���L���)#�Cu�1��a�����P��+#Ðp�f�@���m�iefe��VB�9����͐QR�&�)��W��3<p��:<q���Jz0˩ ���XPyv�2y��!,S��L^�9Z��IL�[I]�A4*uozP�MJ�B�`�X��)�N��;��C0x��Z��8�i�i�ł�� �Z��\A͌���   =�Q���O�m�Yo**Y	�0�Y�c�1  q��yfЄK����{a��4Pf�� �ͤ���%k֞8�g٤h��:"{�д��.R�]���rC,�w{+o S�cj��L$8�f�",\J��M���IC�4V�7���hcL�0'x2Mm@�Eޘ��Z�L�R?}s��pW�����z�*n�A�Ҳ}�E����W�y���抺�C:�s)ק'l����+���W�71�a��4���R�2i���*�=]�(n,��کV�3L
��4
S6(��У�K�E
�OT����h��5�~�H8��h�%ޖj>$�ѐ��>&�=^ג�$n��"�� H���-�k|H�� �7G��&5�n7�!�Y�[���pe���"���0�]Cq��6,�e*L�CXѽ;/��e�()x4gݿ� �V��������bt*�����2�P	pLA�R5�|J��W�Ռ]���گes=���ڞc��4���f��gt㧬f��7�2�+	T%�>�n�ܰ ϲ"|RtA˒v���m����p�.����ϊ�uT�PMCKó�jY�tk��s=�hO��V����^�qa��8j�^a��z��Of�2N�~��}�༳p9����)Ha�)ͷ���Yq���*�N/�Z���ϧ����
�@�     