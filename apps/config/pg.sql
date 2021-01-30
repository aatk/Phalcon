-- Table: public.users

-- DROP TABLE public.users;

CREATE TABLE public.users
(
    firstname character varying(70) COLLATE pg_catalog."default",
    secondname character varying(70) COLLATE pg_catalog."default",
    surname character varying(70) COLLATE pg_catalog."default",
    id integer NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    CONSTRAINT users_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.users
    OWNER to postgres;

GRANT ALL ON TABLE public.users TO postgres WITH GRANT OPTION;
-- Index: id

-- DROP INDEX public.id;

CREATE UNIQUE INDEX id
    ON public.users USING btree
    (id ASC NULLS LAST)
    TABLESPACE pg_default;