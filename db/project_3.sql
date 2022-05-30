PGDMP     "    ,    	        	    y         	   project_3    9.6.22    9.6.22 ;    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            �           1262    123358 	   project_3    DATABASE     �   CREATE DATABASE project_3 WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_Indonesia.1252' LC_CTYPE = 'English_Indonesia.1252';
    DROP DATABASE project_3;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    4                        3079    12387    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    1                        3079    123359    pgcrypto 	   EXTENSION     <   CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;
    DROP EXTENSION pgcrypto;
                  false    4            �           0    0    EXTENSION pgcrypto    COMMENT     <   COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';
                       false    2            �            1259    123396    msaccessgroup    TABLE     p  CREATE TABLE public.msaccessgroup (
    accessgroupid integer NOT NULL,
    userid numeric(100,0) NOT NULL,
    usergroupid numeric(100,0) NOT NULL,
    isactive boolean NOT NULL,
    createdby numeric(100,0) NOT NULL,
    createddate timestamp without time zone NOT NULL,
    updatedby numeric(100,0) NOT NULL,
    updateddate timestamp without time zone NOT NULL
);
 !   DROP TABLE public.msaccessgroup;
       public         postgres    false    4            �            1259    123399    msaccessgroup_accessgroupid_seq    SEQUENCE     �   CREATE SEQUENCE public.msaccessgroup_accessgroupid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.msaccessgroup_accessgroupid_seq;
       public       postgres    false    186    4            �           0    0    msaccessgroup_accessgroupid_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.msaccessgroup_accessgroupid_seq OWNED BY public.msaccessgroup.accessgroupid;
            public       postgres    false    187            �            1259    123401    msaccessmenu    TABLE     n  CREATE TABLE public.msaccessmenu (
    id integer NOT NULL,
    usergroupid numeric(100,0) NOT NULL,
    menuid numeric(100,0) NOT NULL,
    componentid numeric(100,0) NOT NULL,
    createdby numeric(100,0) NOT NULL,
    createddate timestamp without time zone NOT NULL,
    updatedby numeric(100,0) NOT NULL,
    updateddate timestamp without time zone NOT NULL
);
     DROP TABLE public.msaccessmenu;
       public         postgres    false    4            �            1259    123404    msaccessmenu_id_seq    SEQUENCE     |   CREATE SEQUENCE public.msaccessmenu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.msaccessmenu_id_seq;
       public       postgres    false    4    188            �           0    0    msaccessmenu_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.msaccessmenu_id_seq OWNED BY public.msaccessmenu.id;
            public       postgres    false    189            �            1259    123411 	   mscompany    TABLE     J  CREATE TABLE public.mscompany (
    companyid integer NOT NULL,
    companyname character(200) NOT NULL,
    address character(200) NOT NULL,
    createdby numeric(100,0) NOT NULL,
    createddate timestamp without time zone NOT NULL,
    updatedby numeric(100,0) NOT NULL,
    updateddate timestamp without time zone NOT NULL
);
    DROP TABLE public.mscompany;
       public         postgres    false    4            �            1259    123414    mscompany_companyid_seq    SEQUENCE     �   CREATE SEQUENCE public.mscompany_companyid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.mscompany_companyid_seq;
       public       postgres    false    190    4            �           0    0    mscompany_companyid_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.mscompany_companyid_seq OWNED BY public.mscompany.companyid;
            public       postgres    false    191            �            1259    123416    mscomponent    TABLE     T  CREATE TABLE public.mscomponent (
    componentid integer NOT NULL,
    componentname character(100) NOT NULL,
    description character(100) NOT NULL,
    createdby numeric(100,0) NOT NULL,
    createddate timestamp without time zone NOT NULL,
    updatedby numeric(100,0) NOT NULL,
    updateddate timestamp without time zone NOT NULL
);
    DROP TABLE public.mscomponent;
       public         postgres    false    4            �            1259    123419    mscomponent_componentid_seq    SEQUENCE     �   CREATE SEQUENCE public.mscomponent_componentid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.mscomponent_componentid_seq;
       public       postgres    false    4    192            �           0    0    mscomponent_componentid_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.mscomponent_componentid_seq OWNED BY public.mscomponent.componentid;
            public       postgres    false    193            �            1259    123429    msmenu    TABLE     �  CREATE TABLE public.msmenu (
    menuid integer NOT NULL,
    masterid numeric(100,0),
    menuname character(100) NOT NULL,
    menulink character(100) NOT NULL,
    seq numeric(100,0) NOT NULL,
    menuicon character(100),
    isactive boolean NOT NULL,
    createdby numeric(100,0) NOT NULL,
    createddate timestamp without time zone NOT NULL,
    updatedby numeric NOT NULL,
    updateddate timestamp without time zone NOT NULL
);
    DROP TABLE public.msmenu;
       public         postgres    false    4            �            1259    123435    msmenu_menuid_seq    SEQUENCE     z   CREATE SEQUENCE public.msmenu_menuid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.msmenu_menuid_seq;
       public       postgres    false    4    194            �           0    0    msmenu_menuid_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.msmenu_menuid_seq OWNED BY public.msmenu.menuid;
            public       postgres    false    195            �            1259    123447    msuser    TABLE     �  CREATE TABLE public.msuser (
    userid integer NOT NULL,
    username character(200) NOT NULL,
    password character(200) NOT NULL,
    companyid numeric(100,0) NOT NULL,
    isactive boolean NOT NULL,
    createdby numeric(100,0) NOT NULL,
    createddate timestamp without time zone NOT NULL,
    updatedby numeric(100,0) NOT NULL,
    updateddate timestamp without time zone NOT NULL
);
    DROP TABLE public.msuser;
       public         postgres    false    4            �            1259    123450    msuser_userid_seq    SEQUENCE     z   CREATE SEQUENCE public.msuser_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.msuser_userid_seq;
       public       postgres    false    196    4            �           0    0    msuser_userid_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.msuser_userid_seq OWNED BY public.msuser.userid;
            public       postgres    false    197            �            1259    123452    msusergroup    TABLE     P  CREATE TABLE public.msusergroup (
    groupid integer NOT NULL,
    groupname character varying(100) NOT NULL,
    createddate timestamp(6) without time zone NOT NULL,
    createdby numeric(100,0) NOT NULL,
    updateddate timestamp(6) without time zone NOT NULL,
    updatedby numeric(100,0) NOT NULL,
    isactive boolean NOT NULL
);
    DROP TABLE public.msusergroup;
       public         postgres    false    4            �            1259    123455    msusergroup_groupid_seq    SEQUENCE     �   CREATE SEQUENCE public.msusergroup_groupid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.msusergroup_groupid_seq;
       public       postgres    false    4    198            �           0    0    msusergroup_groupid_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.msusergroup_groupid_seq OWNED BY public.msusergroup.groupid;
            public       postgres    false    199                       2604    123483    msaccessgroup accessgroupid    DEFAULT     �   ALTER TABLE ONLY public.msaccessgroup ALTER COLUMN accessgroupid SET DEFAULT nextval('public.msaccessgroup_accessgroupid_seq'::regclass);
 J   ALTER TABLE public.msaccessgroup ALTER COLUMN accessgroupid DROP DEFAULT;
       public       postgres    false    187    186                       2604    123484    msaccessmenu id    DEFAULT     r   ALTER TABLE ONLY public.msaccessmenu ALTER COLUMN id SET DEFAULT nextval('public.msaccessmenu_id_seq'::regclass);
 >   ALTER TABLE public.msaccessmenu ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    189    188                       2604    123486    mscompany companyid    DEFAULT     z   ALTER TABLE ONLY public.mscompany ALTER COLUMN companyid SET DEFAULT nextval('public.mscompany_companyid_seq'::regclass);
 B   ALTER TABLE public.mscompany ALTER COLUMN companyid DROP DEFAULT;
       public       postgres    false    191    190                       2604    123487    mscomponent componentid    DEFAULT     �   ALTER TABLE ONLY public.mscomponent ALTER COLUMN componentid SET DEFAULT nextval('public.mscomponent_componentid_seq'::regclass);
 F   ALTER TABLE public.mscomponent ALTER COLUMN componentid DROP DEFAULT;
       public       postgres    false    193    192                       2604    123489    msmenu menuid    DEFAULT     n   ALTER TABLE ONLY public.msmenu ALTER COLUMN menuid SET DEFAULT nextval('public.msmenu_menuid_seq'::regclass);
 <   ALTER TABLE public.msmenu ALTER COLUMN menuid DROP DEFAULT;
       public       postgres    false    195    194                        2604    123492    msuser userid    DEFAULT     n   ALTER TABLE ONLY public.msuser ALTER COLUMN userid SET DEFAULT nextval('public.msuser_userid_seq'::regclass);
 <   ALTER TABLE public.msuser ALTER COLUMN userid DROP DEFAULT;
       public       postgres    false    197    196            !           2604    123493    msusergroup groupid    DEFAULT     z   ALTER TABLE ONLY public.msusergroup ALTER COLUMN groupid SET DEFAULT nextval('public.msusergroup_groupid_seq'::regclass);
 B   ALTER TABLE public.msusergroup ALTER COLUMN groupid DROP DEFAULT;
       public       postgres    false    199    198            �          0    123396    msaccessgroup 
   TABLE DATA               �   COPY public.msaccessgroup (accessgroupid, userid, usergroupid, isactive, createdby, createddate, updatedby, updateddate) FROM stdin;
    public       postgres    false    186   �D       �           0    0    msaccessgroup_accessgroupid_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.msaccessgroup_accessgroupid_seq', 6, true);
            public       postgres    false    187            �          0    123401    msaccessmenu 
   TABLE DATA               |   COPY public.msaccessmenu (id, usergroupid, menuid, componentid, createdby, createddate, updatedby, updateddate) FROM stdin;
    public       postgres    false    188   DE       �           0    0    msaccessmenu_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.msaccessmenu_id_seq', 414, true);
            public       postgres    false    189            �          0    123411 	   mscompany 
   TABLE DATA               t   COPY public.mscompany (companyid, companyname, address, createdby, createddate, updatedby, updateddate) FROM stdin;
    public       postgres    false    190   �E       �           0    0    mscompany_companyid_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.mscompany_companyid_seq', 7, true);
            public       postgres    false    191            �          0    123416    mscomponent 
   TABLE DATA               ~   COPY public.mscomponent (componentid, componentname, description, createdby, createddate, updatedby, updateddate) FROM stdin;
    public       postgres    false    192   �F       �           0    0    mscomponent_componentid_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.mscomponent_componentid_seq', 6, true);
            public       postgres    false    193            �          0    123429    msmenu 
   TABLE DATA               �   COPY public.msmenu (menuid, masterid, menuname, menulink, seq, menuicon, isactive, createdby, createddate, updatedby, updateddate) FROM stdin;
    public       postgres    false    194   NG       �           0    0    msmenu_menuid_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.msmenu_menuid_seq', 27, true);
            public       postgres    false    195            �          0    123447    msuser 
   TABLE DATA               �   COPY public.msuser (userid, username, password, companyid, isactive, createdby, createddate, updatedby, updateddate) FROM stdin;
    public       postgres    false    196   H       �           0    0    msuser_userid_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.msuser_userid_seq', 2, true);
            public       postgres    false    197            �          0    123452    msusergroup 
   TABLE DATA               s   COPY public.msusergroup (groupid, groupname, createddate, createdby, updateddate, updatedby, isactive) FROM stdin;
    public       postgres    false    198   �H       �           0    0    msusergroup_groupid_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.msusergroup_groupid_seq', 63, true);
            public       postgres    false    199            #           2606    123499     msaccessgroup msaccessgroup_pkey 
   CONSTRAINT     i   ALTER TABLE ONLY public.msaccessgroup
    ADD CONSTRAINT msaccessgroup_pkey PRIMARY KEY (accessgroupid);
 J   ALTER TABLE ONLY public.msaccessgroup DROP CONSTRAINT msaccessgroup_pkey;
       public         postgres    false    186    186            %           2606    123501    msaccessmenu msaccessmenu_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.msaccessmenu
    ADD CONSTRAINT msaccessmenu_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.msaccessmenu DROP CONSTRAINT msaccessmenu_pkey;
       public         postgres    false    188    188            '           2606    123505    mscompany mscompany_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.mscompany
    ADD CONSTRAINT mscompany_pkey PRIMARY KEY (companyid);
 B   ALTER TABLE ONLY public.mscompany DROP CONSTRAINT mscompany_pkey;
       public         postgres    false    190    190            )           2606    123507    mscomponent mscomponent_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY public.mscomponent
    ADD CONSTRAINT mscomponent_pkey PRIMARY KEY (componentid);
 F   ALTER TABLE ONLY public.mscomponent DROP CONSTRAINT mscomponent_pkey;
       public         postgres    false    192    192            +           2606    123511    msmenu msmenu_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.msmenu
    ADD CONSTRAINT msmenu_pkey PRIMARY KEY (menuid);
 <   ALTER TABLE ONLY public.msmenu DROP CONSTRAINT msmenu_pkey;
       public         postgres    false    194    194            -           2606    123517    msuser msuser_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.msuser
    ADD CONSTRAINT msuser_pkey PRIMARY KEY (userid);
 <   ALTER TABLE ONLY public.msuser DROP CONSTRAINT msuser_pkey;
       public         postgres    false    196    196            /           2606    123519    msusergroup msusergroup_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.msusergroup
    ADD CONSTRAINT msusergroup_pkey PRIMARY KEY (groupid);
 F   ALTER TABLE ONLY public.msusergroup DROP CONSTRAINT msusergroup_pkey;
       public         postgres    false    198    198            �   H   x�m��	�0Cѳ=EH���P��1�?Mo-�$x����b��9�X�xk6��Exn��4����կ��o6�8      �   �   x����� E�u�"dd?>jI�u+Ҍ���,]� Zފl:�8�r��.�����{�xu6�ҽ����"۫��U�@��������%wd��^���]j��5=O�[=�]�{�\�{�Kb[���e��:^��Uw ]�N��(-G���\�{p���tF��;�w~B_R-�;      �   u   x�3�L,-�O�H�U″$1/=�H�K(���FF�����
�FV��V�Ȣ�
�VFfV�f\��!z
��E)�%��v
�0�?C+SC������������P�+F��� �k�      �   �   x�œ�
�@E뙯�0��5d;a�$��Ѥ�B��B���hBȴC��͜�Z(���A9M��m}b�jk2}ʌSֆ���D�ZI�7R��MZ�3�9�b��FA��%mI֜3tG>EݥnJ�Cw_�Q�꜡g{�=@�p�6Z�����a��S4�Wq"� �s���o��o��}�;��"> b�?      �   �   x�œ��0Eg�+"1�:�����%C��Km3����*��5���!�:�Ɓ�t��.J5 �J#f�H a���	,7X��>5��S�H��׀H}�|��Y���V@�7���k�L�����E2g�^%�I��Ɇs��0�S.�g�{���`��n����П.��ArO��^���������      �   �   x�3�LL���S��SŨR��@%�)�H����,4����?�7�;�0�"�з �=���9$/(ͧ�,�Ҵ�4##8�ܧ4x��8M9K89��u,t,�@�.j�kh�``dedneh����� �H�      �   t   x�35�L,��.N�J�4202�5��5�P02�26�24�4D5�26�22��q��r��)8��f�i"S�fK]#cC+��)P���̀U��!X����%�6c�X[� �$�     