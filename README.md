Archivage militant
==================

# De quoi s'agit-il ?

voir http://lite2.framapad.org/p/archivage-militant

# Utilisation

```
php tools/archive.php recipes/quefaitlapolice.json 
Following recipe 'recipes/quefaitlapolice.json'...
10 articles added
done
```

et la deuxième fois :

```
php tools/archive.php recipes/quefaitlapolice.json 
Following recipe 'recipes/quefaitlapolice.json'...
10 articles checked
done
```

ensuite on pourra exporter le répertoire `sites/quefaitlapolice-samizdat-net` avec git ou BTSync

voici son format :

```
sites/
└── quefaitlapolice-samizdat-net
    ├── 2013
    │   ├── 2013-10
    │   │   ├── 20131014140530-d437a95f2.json
    │   │   └── 20131028115133-0860fffb4.json
    │   ├── 2013-11
    │   │   └── 20131112085741-e1a4f5e4f.json
    │   └── 2013-12
    │       ├── 20131201090659-e07803da8.json
    │       ├── 20131212084904-c693c9bb8.json
    │       └── 20131229085036-0a1c64222.json
    ├── 2014
    │   ├── 2014-01
    │   │   ├── 20140113085406-eca3d38f5.json
    │   │   └── 20140131112345-93d15652a.json
    │   ├── 2014-02
    │   │   └── 20140227093226-f1e45d57d.json
    │   └── 2014-04
    │       └── 20140401130106-70a8fb38e.json
    └── index.json

```



# Divers 

## Cache

Astuce pour ajouter un cache aux fux rss :
`mkdir cache`


## 
