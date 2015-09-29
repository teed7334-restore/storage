--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: ugroup; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ugroup (
    id bigint NOT NULL,
    name character varying(50) NOT NULL,
    description text,
    is_disabled boolean NOT NULL
);


ALTER TABLE ugroup OWNER TO postgres;

--
-- Data for Name: ugroup; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO ugroup VALUES (1, 'wheel', 'super user group', true);
INSERT INTO ugroup VALUES (2, 'system', 'system agent', true);
INSERT INTO ugroup VALUES (1000, 'users', 'users', true);


--
-- Name: ugroup_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ugroup
    ADD CONSTRAINT ugroup_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: ugroup; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE ugroup FROM PUBLIC;
REVOKE ALL ON TABLE ugroup FROM postgres;
GRANT ALL ON TABLE ugroup TO postgres;
GRANT ALL ON TABLE ugroup TO test;


--
-- PostgreSQL database dump complete
--

